<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Model\Source;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Option\ArrayInterface;

class QuoteId implements ArrayInterface
{
    protected $request;
    public function __construct(
        Http $request
    )
    {
        $this->request = $request;
    }
    public function toOptionArray(): array
    {
        $quoteId = $this->request->getParam('quote_id');

        return [
            [
                'value' => 1,
                'label' => __('QuoteId'),
            ],
        ];

    }
}
