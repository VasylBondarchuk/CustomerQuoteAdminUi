<?php

namespace Training\CustomerQuoteAdminUi\Block\Adminhtml\Quote\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeclineButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return [
            'label' => __('Decline'),
            'on_click' => sprintf("location.href = '%s';", $this->getDeclineUrl()),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'quote_view_form.quote_view_form',
                                'actionName' => 'decline',
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

    private function getDeclineUrl()
    {
        return $this->getUrl('*/*/decline',['quote_id'=>$this->getQuoteId()]);
    }
}

