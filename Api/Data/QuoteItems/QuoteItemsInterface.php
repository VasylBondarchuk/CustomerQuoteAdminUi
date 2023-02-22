<?php

namespace Training\CustomerQuoteAdminUi\Api\Data\QuoteItems;

/**
 *
 */
interface QuoteItemsInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const QUOTE_ITEM_ID = 'quote_item_id';
    /**
     *
     */
    const PRODUCT_ID = 'product_id';
    /**
     *
     */
    const QUOTE_ID = 'quote_id';
    /**
     *
     */
    const PROPOSED_QTY = 'proposed_qty';
    /**
     *
     */
    const PROPOSED_PRICE = 'proposed_price';

    /**
     * @return int|null
     */
    public function getQuoteiItemId(): ?int;

    /**
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * @return int|null
     */
    public function getQuoteId(): ?int;

    /**
     * @return float|null
     */
    public function getProposedQty(): ?float;

    /**
     * @return float|null
     */
    public function getProposedPrice(): ?float;

    /**
     * @param int $quoteItemId
     * @return QuoteItemsInterface
     */
    public function setQuoteiItemId(int $quoteItemId): QuoteItemsInterface;

    /**
     * @param int $productId
     * @return QuoteItemsInterface
     */
    public function setProductId(int $productId): QuoteItemsInterface;

    /**
     * @param int $quotetId
     * @return QuoteItemsInterface
     */
    public function setQuoteId(int $quotetId): QuoteItemsInterface;

    /**
     * @param float $proposedQty
     * @return QuoteItemsInterface
     */
    public function setProposedQty(float $proposedQty): QuoteItemsInterface;

    /**
     * @param float $proposedPrice
     * @return QuoteItemsInterface
     */
    public function setProposedPrice(float $proposedPrice): QuoteItemsInterface;
}

