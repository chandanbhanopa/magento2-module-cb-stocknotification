<?php

Namespace Chandan\StockNotification\Cron;

use Chandan\StockNotification\Model\ResourceModel\StockNotification\CollectionFactory;
use Chandan\StockNotification\ViewModel\StockNotification as StockNotificationVm;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Mail\Template\TransportBuilder;

class StockNotification {
    
    private $stockNotificationCollectionFactory;

    private $stockNotificationVm;

    private $customerRepository;

    private $transportBuilder;

    public function __construct(
        CollectionFactory $stockNotificationCollectionFactory, StockNotificationVm $stockNotificationVm, CustomerRepositoryInterface $customerRepository, TransportBuilder $transportBuilder) {

        $this->stockNotificationCollectionFactory = $stockNotificationCollectionFactory;
        $this->stockNotificationVm = $stockNotificationVm;
        $this->customerRepository = $customerRepository;
        $this->transportBuilder = $transportBuilder;

    }
   
    public function execute() {
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
    }
}