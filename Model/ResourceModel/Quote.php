<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 *
 */
class Quote extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('negotiable_quotes', 'quote_id');
    }
}
