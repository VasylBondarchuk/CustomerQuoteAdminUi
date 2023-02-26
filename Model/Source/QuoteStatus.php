<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Model\Source;

use Magento\Framework\Option\ArrayInterface;
use Training\CustomerQuoteAdminUi\Model\UpdateQuote;

class QuoteStatus implements ArrayInterface
{
    /**
     * Get options
     *
     * @return array
     */

    const OPTION_VALUES = [
        UpdateQuote::QUOTE_STATUS_NEW,
        UpdateQuote::QUOTE_STATUS_OPEN,
        UpdateQuote::QUOTE_STATUS_SUBMITTED,
        UpdateQuote::QUOTE_STATUS_UPDATED,
        UpdateQuote::QUOTE_STATUS_CLIENT_REVIEWED,
        UpdateQuote::QUOTE_STATUS_ORDERED,
        UpdateQuote::QUOTE_STATUS_CLOSED,
        UpdateQuote::QUOTE_STATUS_DECLINED
    ];
    const OPTION_LABELS = self::OPTION_VALUES;

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $toOptionArray = [];
        foreach($this->getOptionValuesLabelsArray() as $value => $label){
            $toOptionArray[] = [
                'label' => __($label),
                'value' => $value
            ];
        }
        return $toOptionArray;
    }

    /**
     * @return array
     */
    public function getOptionValuesLabelsArray() : array
    {
        return array_combine(self::OPTION_VALUES, self:: OPTION_LABELS);
    }
}

