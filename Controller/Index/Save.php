<?php

namespace Chandan\StockNotification\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Chandan\StockNotification\Model\StockNotificationFactory;
use Chandan\StockNotification\ViewModel\StockNotification;
use Magento\Checkout\Model\Cart as CustomerCart;


class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

     /**
     * @var Chandan\StockNotification\Model\StockNotification
     */
    protected $stockNotification;

    protected $stockNotificationVm;

    protected $cart;

    
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        StockNotificationFactory $stockNotification,
        StockNotification $stockNotificationVm,
        CustomerCart $cart
    
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->stockNotification = $stockNotification;
        $this->stockNotificationVm = $stockNotificationVm;
        $this->cart = $cart;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {

        $resultJson = $this->jsonFactory->create();
    	$response = array();
        $post = $this->getRequest()->getPost();
        $product = $this->getRequest()->getPost('product');
        $customerId = $this->getRequest()->getPost('customer_id');
        
        try {
            foreach($product as $key => $data) {
                $stockNotificationModel = $this->stockNotification->create();
                $stockNotificationModel->setData("customer_id", $customerId);
                $stockNotificationModel->setData("product_id", $data['id']);
                $stockNotificationModel->setData("product_sku", $data['sku']);
                $stockNotificationModel->setData("product_name", $data['name']);
                $itemId = $data['quote_item_id'];
                $stockNotificationModel->save();
                if($stockNotificationModel->getId()) {
                    //$this->cart->removeItem($itemId)->save();
                }
            }
            $response['status'] = 1;
            $response['message'] = "Your products added to notifiction list";


        } catch(Exception $e ) {
            $response['status'] = 0;
            $response['message'] = "Something went worng. Please try again";
        } 

        $this->stockNotificationVm->clearQuoteData();
        return $resultJson->setData($response);
        
    }
}
