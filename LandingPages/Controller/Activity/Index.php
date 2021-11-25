<?php

namespace Alice\LandingPages\Controller\Activity;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page as PageResult;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Index implements HttpGetActionInterface {

    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;

    /**
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var PageResult $pageResult */
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
