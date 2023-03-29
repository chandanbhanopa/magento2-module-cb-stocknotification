<?php

namespace Chandan\StockNotification\Ui\DataProvider\StockNotification;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

/**
 * Class Collection
 * @package Neosoft\PostSellSurvey\Ui\DataProvider\Collection
 */
class Collection extends SearchResult
{
    /**
     * Override _initSelect to add custom columns
     *
     * @return void
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        
        return $this;
    }
}
