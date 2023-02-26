<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Model\ResourceModel\Quote;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Training\CustomerQuoteAdminUi\Model\Quote as QuoteModel;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\Quote as QuoteResourceModel;

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
