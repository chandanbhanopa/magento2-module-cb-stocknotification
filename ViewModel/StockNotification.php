<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Chandan\StockNotification\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Catalog\Api\ProductRepositoryInterfaceFactory;
use Magento\Catalog\Helper\Image;


/**
 * Cart form view model.
 */
class StockNotification implements ArgumentInterface {

	/**
	 * $customerSession
	 * @var Magento\Customer\Model\Session
	 */
	
	private $customerSession;

	/**
	 * $checkoutSession
	 * @var Magento\Checkout\Model\Session
	 */
	
	private $checkoutSession;

	/**
	 * $stockItemRepository
	 * @var Magento\CatalogInventory\Model\Stock\StockItemRepository
	 */
	
	private $stockItemRepository;

    protected $_productRepositoryFactory;

    protected $imageHelper;
    

    /**
     * @param CustomerSession                   $customerSession          
     * @param CheckoutSession                   $checkoutSession          
     * @param StockItemRepository               $stockItemRepository      
     * @param ProductRepositoryInterfaceFactory $productRepositoryFactory 
     * @param Image                             $imageHelper              
     */
    public function __construct(
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
        StockItemRepository $stockItemRepository,
        ProductRepositoryInterfaceFactory $productRepositoryFactory,
        Image $imageHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->stockItemRepository = $stockItemRepository;
        $this->_productRepositoryFactory = $productRepositoryFactory;
        $this->imageHelper = $imageHelper;
    }

    /**
     * Check if clear shopping cart button is enabled
     *
     * @return bool
     */
    public function getQuoteProducts()
    {
        return $this->checkoutSession->getQuote();
    }

    /**
     * 
     * @param  int $productId 
     * @return boolean true | false
     */
    public function getStockStatus($productId) 
    {
    	return $this->stockItemRepository->get($productId)->getIsInStock();
    }

    /**
     * 
     * @param  int $productId
     * @return string $product Url
     */
    public function getProductImages($productId) 
    {
        $product = $this->_productRepositoryFactory->create();
        $productData = $product->getById(1);
        return $this->imageHelper->init($productData, 'product_thumbnail_image')->getUrl();
    }

    /**
     * clearQuoteData clear the checkout session
     * @return mix
     */
    public function clearQuoteData() {
       return $this->customerSession->clearStorage();
    }

}

