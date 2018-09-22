<?php

namespace N98Hackathon\Magameto\Controller\Appcache;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\DesignInterface;

class Manifest extends Action
{
    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepository;

    public function __construct(Context $context, \Magento\Framework\View\Asset\Repository $assetRepository)
    {
        parent::__construct($context);

        $this->assetRepository = $assetRepository;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_RAW);

        $page->setHeader('Content-Type', 'text/cache-manifest', true);

        $response = $page->setContents('CACHE MANIFEST
# v0.4 ' . date('Y-m-d', time()) . '

# Explicitly cached \'master entries\'.
#CACHE:
#/dummy.png

# Resources that require the user to be online.
NETWORK:
magameto/report/score

FALLBACK:
* ' . $this->assetRepository->getUrlWithParams('N98Hackathon_Magameto/magameto/game.html', []));

        return $response;
    }
}
