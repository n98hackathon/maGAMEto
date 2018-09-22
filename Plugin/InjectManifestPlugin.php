<?php

namespace N98Hackathon\Magameto\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Page\Config;
use Magento\Store\Model\StoreManagerInterface;

class InjectManifestPlugin
{
    const CONFIG_PATH_MANIFEST = 'n98_hackathon/head/manifest';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $config;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * InjectManifestPlugin constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     */
    public function __construct(ScopeConfigInterface $config, StoreManagerInterface $storeManager)
    {
        $this->config = $config;
        $this->storeManager = $storeManager;
    }

    /**
     * @param Config $subject
     * @param string $elementType
     *
     * @return \string[]
     */
    public function aroundGetElementAttributes(Config $subject, callable $proceed, $elementType)
    {
        if (!$this->isEnabled()) {
            return $proceed($elementType);
        }

        if ($elementType === Config::ELEMENT_TYPE_HTML) {
            $orig = $proceed($elementType);

            //$manifest = $this->config->getValue(self::CONFIG_PATH_MANIFEST);
            $manifest = $this->storeManager->getStore()->getBaseUrl() . 'magameto/appcache/manifest';
            $orig['manifest'] = $manifest;
            
            return $orig;
        }

        return $proceed($elementType);
    }

    /**
     * @param Config $subject
     * @param string $elementType
     *
     * @return \string[]
     */
    public function aroundGetElementAttribute(Config $subject, callable $proceed, $elementType, $attribute)
    {
        if (!$this->isEnabled()) {
            return $proceed($elementType, $attribute);
        }

        if ($elementType === Config::ELEMENT_TYPE_HTML) {
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