<?php

namespace Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Training\CustomerQuoteAdminUi\Model\QuoteItems as QuoteItemsModel;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems as QuoteItemsResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            QuoteItemsModel::class,
            QuoteItemsResourceModel::class
        );
    }
}
