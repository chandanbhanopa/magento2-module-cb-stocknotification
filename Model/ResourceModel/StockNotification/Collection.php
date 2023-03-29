<?php

namespace Chandan\StockNotification\Model\ResourceModel\StockNotification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Chandan\StockNotification\Model\StockNotification as StockNotificationModel;
use Chandan\StockNotification\Model\ResourceModel\StockNotification as StockNotificationResourceModel;

/**
 * Collection class for Questions
 */
class Collection extends AbstractCollection {
    /**
     * _construct description
     * @return void
     */
    protected function _construct()
    {
        $this->_init(StockNotificationModel::class, StockNotificationResourceModel::class);
    }
}