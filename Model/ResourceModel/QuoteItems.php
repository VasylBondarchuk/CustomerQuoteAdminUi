<?php

namespace Training\CustomerQuoteAdminUi\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 *
 */
class QuoteItems extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('training_negotiable_quote_items', 'quote_item_id');
    }
}
