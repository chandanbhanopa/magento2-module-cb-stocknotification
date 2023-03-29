<?php

namespace Chandan\StockNotification\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StockNotification extends AbstractDb {
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('stock_notification', 'entity_id');
    }
}
