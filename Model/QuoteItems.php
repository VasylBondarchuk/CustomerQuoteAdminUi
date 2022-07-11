<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use CustomerQuote\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsInterface;

/**
 *
 */
class QuoteItems extends AbstractExtensibleModel implements QuoteItemsInterface
{
    /**
     * @return void
    */
    protected function _construct()
    {
        $this->_init(ResourceModel\QuoteItems::class);
    }
    /**
     * @return int|null
     */
    public function getQuoteiItemId(): ?int
    {
        return $this->getData(self::QUOTE_ITEM_ID);
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @return int|null
     */
    public function getQuoteId(): ?int
    {
        return $this->getData(self::QUOTE_ID);
    }

    /**
     * @return int|null
     */
    public function getProposedQty(): ?float
    {
        return $this->getData(self::PROPOSED_QTY);
    }

    /**
     * @return float|null
     */
    public function getProposedPrice(): ?float
    {
        return $this->getData(self::PROPOSED_PRICE);
    }


    /**
     * @param int $quoteItemId
     * @return QuoteItemsInterface
     */
    public function setQuoteiItemId(int $quoteItemId): QuoteItemsInterface
    {
        return $this->setData(self::QUOTE_ITEM_ID, $quoteItemId);
    }

    /**
     * @param int $productId
     * @return QuoteItemsInterface
     */
    public function setProductId(int $productId): QuoteItemsInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @param int $quotetId
     * @return QuoteItemsInterface
     */
    public function setQuoteId(int $quotetId): QuoteItemsInterface
    {
        return $this->setData(self::QUOTE_ID, $quotetId);
    }

    /**
     * @param float $proposedQty
     * @return QuoteItemsInterface
     */
    public function setProposedQty(float $proposedQty): QuoteItemsInterface
    {
        return $this->setData(self::PROPOSED_QTY, $proposedQty);
    }

    /**
     * @param float $proposedPrice
     * @return QuoteItemsInterface
     */
    function setProposedPrice(float $proposedPrice): QuoteItemsInterface
    {
        return $this->setData(self::PROPOSED_PRICE, $proposedPrice);
    }
}
