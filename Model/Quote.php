<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteInterface;

/**
 *
 */
class Quote extends AbstractExtensibleModel implements QuoteInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Quote::class);
    }

    /**
     * @return int|null
     */
    public function getQuoteId(): int
    {
        return (int)$this->getData(self::QUOTE_ID);
    }

    /**
     * @return string
     */
    public function getQuoteName(): string
    {
        return (string)$this->getData(self::QUOTE_NAME);
    }
    
    /**
     * @return string
     */
    public function getQuoteComment(): string
    {
        return (string)$this->getData(self::QUOTE_COMMENT);
    }
    

    /**
     * @return string
     */
    public function getQuoteCreationTime(): string
    {
        return $this->getData(self::QUOTE_UPDATE_TIME);
    }

    /**
     * @return string
     */
    public function getQuoteUpdateTime(): string
    {
        return $this->getData(self::QUOTE_CREATION_TIME);
    }

    /**
     * @return int
     */
    public function getQuoteAuthorId(): int
    {
        return $this->getData(self::QUOTE_AUTHOR_ID);
    }

    /**
     * @return string
     */
    public function getQuoteStatus(): string
    {
        return $this->getData(self::QUOTE_STATUS);
    }
    
    
     /**
     * @return string
     */
    public function getQuoteStatusLabel(): string
    {
        return self::ORDER_STATUS_LABEL[$this->getQuoteStatus()];
    }
    

    /**
     * @param int $quoteId
     * @return QuoteInterface
     */
    public function setQuoteId(int $quoteId): QuoteInterface
    {
        return $this->setData(self::QUOTE_ID, $quoteId);
    }

    /**
     * @param string $quoteName
     * @return QuoteInterface
     */
    public function setQuoteName(string $quoteName): QuoteInterface
    {
        return $this->setData(self::QUOTE_NAME, $quoteName);
    }
        
    /**
     * 
     * @param string $quoteComment
     * @return QuoteInterface
     */
    public function setQuoteComment(string $quoteComment): QuoteInterface
    {
        return $this->setData(self::QUOTE_COMMENT, $quoteComment);
    }
    /**
     * @param string $quoteCreationTime
     * @return QuoteInterface
     */
    public function setQuoteCreationTime(string $quoteCreationTime): QuoteInterface
    {
        return $this->setData(self::QUOTE_CREATION_TIME, $quoteCreationTime);
    }

    /**
     * @param string $quoteUpdateTime
     * @return QuoteInterface
     */
    public function setQuoteUpdateTime(string $quoteUpdateTime): QuoteInterface
    {
        return $this->setData(self::QUOTE_UPDATE_TIME, $quoteUpdateTime);
    }

    /**
     * @param int $quoteAuthorId
     * @return QuoteInterface
     */
    public function setQuoteAuthorId(int $quoteAuthorId): QuoteInterface
    {
        return $this->setData(self::QUOTE_AUTHOR_ID, $quoteAuthorId);
    }

    /**
     * @param string $quoteStatus
     * @return QuoteInterface
     */
    public function setQuoteStatus(string $quoteStatus): QuoteInterface
    {
        return $this->setData(self::QUOTE_STATUS, $quoteStatus);
    }
}
