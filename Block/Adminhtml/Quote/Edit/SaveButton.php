<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Block\Adminhtml\Quote\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class SaveButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return [
            'label' => __('Save Item'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'quoteitem_add_form.quoteitem_add_form',
                                'actionName' => 'save',
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
}

