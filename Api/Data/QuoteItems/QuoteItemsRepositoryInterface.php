<?php

namespace Training\CustomerQuoteAdminUi\Api\Data\QuoteItems;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 *
 */
interface QuoteItemsRepositoryInterface
{
    /**
     * @param QuoteItemsInterface $quoteItem
     * @return mixed
     */
    public function save(QuoteItemsInterface $quoteItem) : QuoteItemsInterface;

    /**
     * @param int $quoteItemId
     * @return mixed
     */
    public function getById(int $quoteItemId) : QuoteItemsInterface;

    /**
     * @param int $quoteId
     * @return QuoteItemsInterface
     */
    public function getByQuoteId(int $quoteId): QuoteItemsInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param QuoteItemsInterface $quoteItem
     * @return bool
     */
    public function delete(QuoteItemsInterface $quoteItem): bool;

    /**
     * @param int $quoteItemId
     * @return bool
     */
    public function deleteById(int $quoteItemId): bool;
}
