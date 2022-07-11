<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Block\Adminhtml\Quote\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class AddBySkuButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [];
        if ($this->getQuoteId()) {
            $data = [
                'label' => __('Add Product By SKU'),
                'on_click' => sprintf("location.href = '%s';", $this->getAddBySkuUrl()),
            ];
        }
        return $data;
    }
    public function getAddBySkuUrl()
    {
        return $this->getUrl('*/*/addbysku', ['quote_id' => $this->getQuoteId()]);
    }
}
