<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Block\Adminhtml\Quote\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{
    protected Context $context;

    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function getQuoteId(): int
    {
        return (int)$this->context->getRequest()->getParam('quote_id');
    }

    public function getQuoteItemId(): int
    {
        return (int)$this->context->getRequest()->getParam('quote_item_id');
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
