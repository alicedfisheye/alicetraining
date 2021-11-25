<?php
/**
 * Copyright © Fisheye Media Ltd. All rights reserved.
 * See LICENCE.txt for licence details.
 */

namespace Alice\LandingPages\Block;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Catalog\Block\Product\ImageFactory;

class MyProduct extends Template {

    /**
     * @var ProductFactory
     */
    protected ProductFactory $productFactory;

    /**
     * @var PriceCurrencyInterface
     */
    protected PriceCurrencyInterface $priceCurrency;

    /**
     * @var ImageFactory
     */
    protected ImageFactory $imageFactory;

    /**
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param PriceCurrencyInterface $priceCurrency
     * @param ImageFactory $imageFactory
     */
    public function __construct
    (
        Context $context,
        ProductFactory $productFactory,
        PriceCurrencyInterface $priceCurrency,
        ImageFactory $imageFactory
    )
    {
        $this->productFactory = $productFactory;
        $this->priceCurrency = $priceCurrency;
        $this->imageFactory = $imageFactory;
        parent::__construct($context);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getProduct(int $id): Product
    {
        /** @var Product */
        return $this->productFactory->create()->load($id);
    }

    /**
     * @param float $price
     * @return string
     */
    public function formatPrice(float $price): string
    {
        return $this->priceCurrency->format($price);
    }

    /**
     * @param Product $product
     * @param string $imageType
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function getProductImageUrl(Product $product, string $imageType): string
    {
        return $this->imageFactory->create($product, $imageType)->getImageUrl();
    }
}
