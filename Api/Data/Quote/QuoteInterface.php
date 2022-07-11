<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Api\Data\Quote;

/**
 *
 */
interface QuoteInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const QUOTE_ID = 'quote_id';
    const QUOTE_NAME = 'quote_name';
    const QUOTE_CREATION_TIME = 'quote_creation_time';
    const QUOTE_UPDATE_TIME = 'quote_update_time';
    const QUOTE_AUTHOR_ID = 'quote_author_id';
    const QUOTE_STATUS = 'quote_status';

    /**
     * @return int|null
     */
    public function getQuoteId(): ?int;

    /**
     * @return string
     */
    public function getQuoteName(): string;

    /**
     * @return string|null
     */
    public function getQuoteCreationTime(): ?string;

    /**
     * @return int|null
     */
    public function getQuoteAuthorId(): ?int;

    /**
     * @return string|null
     */
    public function getQuoteStatus(): ?string;


    /**
     * @param int $quoteId
     * @return QuoteInterface
     */
    public function setQuoteId(int $quoteId): QuoteInterface;

    /**
     * @param string $quoteName
     * @return QuoteInterface
     */
    public function setQuoteName(string $quoteName): QuoteInterface;

    /**
     * @param string $quoteCreationTime
     * @return QuoteInterface
     */
    public function setQuoteCreationTime(string $quoteCreationTime): QuoteInterface;

    /**
     * @param int $quoteAuthorId
     * @return QuoteInterface
     */
    public function setQuoteAuthorId(int $quoteAuthorId): QuoteInterface;

    /**
     * @param string $quoteStatus
     * @return QuoteInterface
     */
    public function setQuoteStatus(string $quoteStatus): QuoteInterface;
}

