<?php

namespace Chandan\StockNotification\Model;

use Magento\Framework\Model\AbstractModel;
use Chandan\StockNotification\Model\ResourceModel\StockNotification as StockNotificationResourceModel ;


class StockNotification extends AbstractModel {
	
	/**
     * Initialize resource model
     *
     * @return void
     */
	protected function _construct()
	{
		$this->_init(StockNotificationResourceModel::class);
	}
}
