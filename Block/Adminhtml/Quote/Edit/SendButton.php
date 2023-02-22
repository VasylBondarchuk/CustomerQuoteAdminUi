<?php

namespace Training\CustomerQuoteAdminUi\Block\Adminhtml\Quote\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

class SendButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return [
            'label' => __('Send'),
            'on_click' => sprintf("location.href = '%s';", $this->getSendUrl()),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'quote_view_form.quote_view_form',
                                'actionName' => 'send',
                                'params' => [
                                    false,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
    private function getSendUrl()
    {
        return $this->getUrl('*/*/send',['quote_id'=>$this->getQuoteId()]);
    }
}

