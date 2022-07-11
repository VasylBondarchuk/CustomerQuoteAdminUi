<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Api\Data\QuoteItems;

use Magento\Framework\Api\SearchResultsInterface;

/**
 *
 */
interface QuoteItemsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return array|\Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems(): array;

    /**
     * @param array $items
     * @return QuoteItemsSearchResultsInterface
     */
    public function setItems(array $items): QuoteItemsSearchResultsInterface;
}
