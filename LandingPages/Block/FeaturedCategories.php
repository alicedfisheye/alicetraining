<?php
/**
 * Copyright © Fisheye Media Ltd. All rights reserved.
 * See LICENCE.txt for licence details.
 */

namespace Alice\LandingPages\Block;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\Catalog\Model\Category as CategoryModel;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class FeaturedCategories extends Template {

    /**
     * @var CategoryCollectionFactory
     */
    protected CategoryCollectionFactory $categoryCollectionFactory;

    public function __construct
    (
        Context $context,
        CategoryCollectionFactory $categoryCollectionFactory
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context);
    }

    /**
     * @param int $level
     * @param int $limit
     * @return mixed
     */
    public function getCategories(int $level, int $limit, $sort = null): CategoryCollection
    {
        /** @var CategoryModel */
        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection->addAttributeToSelect('*')
            ->addAttributeToFilter('level', $level)
            ->setPageSize($limit);

        if (isset($sort)) {
            $categoryCollection->addAttributeToSort($sort);
        }

        return $categoryCollection->load();
    }
}
