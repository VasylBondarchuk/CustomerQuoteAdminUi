<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Model\ResourceModel\Quote;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use CustomerQuote\CustomerQuoteAdminUi\Model\Quote as QuoteModel;
use CustomerQuote\CustomerQuoteAdminUi\Model\ResourceModel\Quote as QuoteResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            QuoteModel::class,
            QuoteResourceModel::class
        );
    }
}
