<?php
/**
 * @copyright Copyright (c) 1999-2018. netz98 GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace N98Hackathon\Magameto\Controller\CheckAvailability;


use Magento\Framework\App\Action\Action;

/**
 * index
 */
class index extends Action
{

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_RAW);
        $result->setHttpResponseCode(418);

        return $result;
    }
}