<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Api\Data\Quote;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 *
 */
interface QuoteRepositoryInterface
{
    /**
     * @param QuoteInterface $quote
     * @return mixed
     */
    public function save(QuoteInterface $quote);

    /**
     * @param int $quoteId
     * @return mixed
     */
    public function getById(int $quoteId);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param QuoteInterface $quote
     * @return bool
     */
    public function delete(QuoteInterface $quote): bool;

    /**
     * @param int $quoteId
     * @return bool
     */
    public function deleteById(int $quoteId): bool;
}
