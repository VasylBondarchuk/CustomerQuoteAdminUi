<?php

namespace Training\CustomerQuoteAdminUi\Model\ResourceModel;

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
        $this->_init('training_negotiable_quotes', 'quote_id');
    }
}
