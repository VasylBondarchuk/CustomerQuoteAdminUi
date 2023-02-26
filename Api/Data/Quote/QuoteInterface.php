<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Api\Data\Quote;

/**
 *
 */
interface QuoteInterface
{
    /*
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const QUOTE_ID = 'quote_id';
    const QUOTE_NAME = 'quote_name';
    const QUOTE_COMMENT = 'quote_comment';
    const QUOTE_CREATION_TIME = 'quote_creation_time';
    const QUOTE_UPDATE_TIME = 'quote_update_time';
    const QUOTE_AUTHOR_ID = 'quote_author_id';
    const QUOTE_STATUS = 'quote_status';
    
    const QUOTE_STATUS_NEW = 'new';
    const QUOTE_STATUS_OPEN = 'open';
    const QUOTE_STATUS_SUBMITTED = 'submitted';
    const QUOTE_STATUS_CLIENT_REVIEWED = 'client_reviewed';
    const QUOTE_STATUS_UPDATED = 'updated';
    const QUOTE_STATUS_ORDERED = 'ordered';
    const QUOTE_STATUS_CLOSED = 'closed';
    const QUOTE_STATUS_DECLINED = 'declined';
    
    const ORDER_STATUS_LABEL = [
        self::QUOTE_STATUS_NEW => 'New',
        self::QUOTE_STATUS_OPEN=> 'Open',
        self::QUOTE_STATUS_SUBMITTED => 'Submitted',
        self::QUOTE_STATUS_CLIENT_REVIEWED => 'Client Reviewed',
        self::QUOTE_STATUS_UPDATED => 'Update',
        self::QUOTE_STATUS_ORDERED => 'Ordered',
        self::QUOTE_STATUS_CLOSED => 'closed',
        self::QUOTE_STATUS_DECLINED => 'declined',
    ];

    /**
     * @return int|null
     */
    public function getQuoteId(): ?int;

    /**
     * @return string
     */
    public function getQuoteName(): string;
    
    /**
     * @return string
     */
    public function getQuoteComment(): string;

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
     * 
     * @return string
     */
    public function getQuoteStatusLabel(): string;        
    
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
     * 
     * @param string $quoteName
     * @return QuoteInterface
     */
    public function setQuoteComment(string $quoteName): QuoteInterface;

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

