<?php

namespace N98Hackathon\Magameto\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Page\Config;

class InjectManifestPlugin
{
    const CONFIG_PATH_MANIFEST = 'n98_hackathon/head/manifest';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $config;

    /**
     * InjectManifestPlugin constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     */
    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }


    /**
     * @param \Magento\Framework\View\Page\Config $subject
     * @param string $elementType
     *
     * @return \string[]
     */
    public function aroundGetElementAttributes(Config $subject, callable $proceed, $elementType)
    {
        if(!$this->isEnabled())
        {
            return $proceed($elementType);
        }

        if($elementType === \Magento\Framework\View\Page\Config::ELEMENT_TYPE_HTML)
        {
            $orig = $proceed($elementType);

            $manifest = $this->config->getValue(self::CONFIG_PATH_MANIFEST);
            $orig['manifest'] = $manifest;
            
            return $orig;
        }
        return $proceed($elementType);
    }

    /**
     * @param \Magento\Framework\View\Page\Config $subject
     * @param string $elementType
     *
     * @return \string[]
     */
    public function aroundGetElementAttribute(Config $subject, callable $proceed, $elementType, $attribute)
    {
        if(!$this->isEnabled())
        {
            return $proceed($elementType, $attribute);
        }

        if($elementType === \Magento\Framework\View\Page\Config::ELEMENT_TYPE_HTML)
        {
            $orig = $proceed($elementType, $attribute);

            $orig[] = 'manifest';
            // Awesome logic
        }
        return $proceed($elementType, $attribute);
    }

    /**
     * @return bool
     */
    protected function isEnabled()
    {
        return true;
    }
}