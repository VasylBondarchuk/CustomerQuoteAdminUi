<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Api\Data\Quote;

use Magento\Framework\Api\SearchResultsInterface;

/**
 *
 */
interface QuoteSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Feedback list.
     *
     */
    public function getItems(): array;

    /**
     * @param array $items
     * @return QuoteSearchResultsInterface
     */
    public function setItems(array $items);
}
