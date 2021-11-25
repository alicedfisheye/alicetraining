<?php
/**
 * Copyright © Fisheye Media Ltd. All rights reserved.
 * See LICENCE.txt for licence details.
 */

namespace Alice\LandingPages\Controller\Hero;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page as PageResult;

class Categories implements HttpGetActionInterface {

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
     * @return PageResult
     */
    public function execute()
    {
        /** @var PageResult $pageResult */
        $pageResult = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $pageResult;
    }
}
