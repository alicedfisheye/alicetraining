<?php

namespace Alice\LandingPages\ViewModel;

use Magento\Catalog\Model\Product as ProductModel;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Catalog\Block\Product\ImageFactory;
use Magento\Catalog\Block\Product\Image;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Framework\App\Request\Http;

class ProductsByActivity implements ArgumentInterface {

    const ACTIVITY_PRODUCT_ATTRIBUTE = 'activity';

    /**
     * @var PriceCurrencyInterface
     */
    protected PriceCurrencyInterface $priceCurrency;

    /**
     * @var ImageFactory
     */
    protected ImageFactory $imageFactory;

    /**
     * @var ProductCollectionFactory
     */
    private ProductCollectionFactory $productCollectionFactory;

    /**
     * @var Http
     */
    private Http $http;

    protected $activity;

    /**
     * @param PriceCurrencyInterface $priceCurrency
     * @param ImageFactory $imageFactory
     * @param ProductCollectionFactory $productCollectionFactory
     * @param Http $http
     */
    public function __construct
    (
        PriceCurrencyInterface $priceCurrency,
        ImageFactory $imageFactory,
        ProductCollectionFactory $productCollectionFactory,
        Http $http
    )
    {
        $this->priceCurrency = $priceCurrency;
        $this->imageFactory = $imageFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->http = $http;
        $this->activity = $this->http->getParam('activity');
    }

    /**
     * @param int $limit
     * @param null $sort
     * @return ProductCollection
     */
    public function getProductCollection(int $limit, $sort = null): ProductCollection
    {
        /** @var ProductModel */
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*')
            ->addAttributeToFilter('status', Status::STATUS_ENABLED)
            ->addAttributeToFilter('visibility', Visibility::VISIBILITY_BOTH)
            ->setPageSize($limit);

        if (isset($this->activity)) {
            $productCollection->addAttributeToFilter(self::ACTIVITY_PRODUCT_ATTRIBUTE, $this->activity);
        }

        if (isset($sort)) {
            $productCollection->addAttributeToSort($sort);
        }

        return $productCollection->load();
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
     * @return Image
     */
    public function getProductImageUrl($product, string $imageType): string
    {
        return $this->imageFactory->create($product, $imageType)->getImageUrl();
    }

    /**
     * @param ProductModel $product
     * @param string $attribute
     * @return mixed
     */
    public function getAttributeLabel(ProductModel $product, string $attribute): string
    {
        return $product->getResource()->getAttribute($attribute)->getFrontend()->getValue($product);
    }

    /**
     * @return int|mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }
}
