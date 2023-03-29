<?php

namespace Chandan\StockNotification\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Chandan\StockNotification\Model\StockNotificationFactory;
use Chandan\StockNotification\ViewModel\StockNotification;
use Magento\Checkout\Model\Cart as CustomerCart;

use Chandan\StockNotification\Model\ResourceModel\StockNotification\CollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Mail\Template\TransportBuilder;


class TestCron extends \Magento\Framework\App\Action\Action
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

    private $stockNotificationCollectionFactory;

    private $customerRepository;

    private $transportBuilder;




    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        StockNotificationFactory $stockNotification,
        StockNotification $stockNotificationVm,
        CustomerCart $cart,
        CollectionFactory $stockNotificationCollectionFactory,
        CustomerRepositoryInterface $customerRepository,
        TransportBuilder $transportBuilder,
    
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->stockNotification = $stockNotification;
        $this->stockNotificationVm = $stockNotificationVm;
        $this->cart = $cart;

        $this->stockNotificationCollectionFactory = $stockNotificationCollectionFactory;
        $this->customerRepository = $customerRepository;
        $this->transportBuilder = $transportBuilder;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $outOfStockProduct = $this->stockNotificationCollectionFactory->create();
        foreach($outOfStockProduct as $data) {
            $customerEmail = $this->customerRepository->getById($data['customer_id'])->getEmail();
            $isInStock = $this->stockNotificationVm->getStockStatus($data['product_id']);
            $vars = array();
            $sender = "abc@mailinator.com";
            if($isInStock) {
                $transport = $this->transportBuilder->setTemplateIdentifier('stock_notification')->setTemplateOptions(
                        [
                            'area' => Area::AREA_FRONTEND,
                            'store' => 1
                        ]
                )->setTemplateVars($vars)->setFromByScope($sender)->addTo($customerEmail)->getTransport();

                try {
                    $transport->sendMessage();
                } catch (\Exception $exception) {
                    
                }
            }
        }
    
        
        die;
    }
}

