<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Model;

use CustomerQuote\CustomerQuoteAdminUi\Api\Data\Quote\QuoteInterface;
use CustomerQuote\CustomerQuoteAdminUi\Api\Data\Quote\QuoteRepositoryInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\RequestInterface;

/**
 *
 */
class UpdateQuote
{
    /**
     *
     */
    const QUOTE_STATUS_NEW = 'New';
    /**
     *
     */
    const QUOTE_STATUS_OPEN = 'Open';
    /**
     *
     */
    const QUOTE_STATUS_SUBMITTED = 'Submitted';
    /**
     *
     */
    const QUOTE_STATUS_CLIENT_REVIEWED = 'Client Reviewed';
    /**
     *
     */
    const QUOTE_STATUS_UPDATED = 'Updated';
    /**
     *
     */
    const QUOTE_STATUS_ORDERED = 'Ordered';
    /**
     *
     */
    const QUOTE_STATUS_CLOSED = 'Closed';
    /**
     *
     */
    const QUOTE_STATUS_DECLINED = 'Declined';
    /**
     * @var QuoteRepositoryInterface
     */
    private QuoteRepositoryInterface $quoteRepository;

    /**
     * @var DateTime
     */
    private DateTime $date;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @param QuoteRepositoryInterface $quoteRepository
     * @param DateTime $date
     */
    public function __construct(
        QuoteRepositoryInterface  $quoteRepository,
        DateTime                  $date,
        RequestInterface          $request
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->date = $date;
        $this->request = $request;
    }

    /**
     * @return void
     */
    public function changeQuoteStatusToOpen()
    {
        if($this->getQuoteStatus() === self::QUOTE_STATUS_NEW){
            $this->quoteRepository
                ->save($this->getQuoteModel()
                    ->setQuoteStatus(self::QUOTE_STATUS_OPEN)
                );
        }
    }

    /**
     * @return void
     */
    public function changeQuoteStatusToSubmitted()
    {
        $this->quoteRepository
                ->save($this->getQuoteModel()
                    ->setQuoteStatus(self::QUOTE_STATUS_SUBMITTED)
                );
    }

    /**
     * @return void
     */
    public function changeQuoteStatusToDeclined()
    {
        $this->quoteRepository
            ->save($this->getQuoteModel()
                ->setQuoteStatus(self::QUOTE_STATUS_DECLINED)
        );
    }

    /**
     * @return void
     */
    public function changeQuoteUpdateTime()
    {
        $this->quoteRepository
            ->save($this->getQuoteModel()->setQuoteUpdateTime($this->getCurrentTime())
            );
    }

    /**
     * @param $quoteId
     * @return string
     */
    public function getQuoteStatus() : string
    {
        return $this->getQuoteModel()->getQuoteStatus();
    }

    /**
     * @param $quoteId
     * @return QuoteInterface
     */
    public function getQuoteModel() : QuoteInterface
    {
        return $this->quoteRepository->getById($this->getQuoteIdFromUrl());
    }

    /**
     * @return string
     */
    public function getCurrentTime() : string
    {
        return $this->date->gmtDate();
    }

    /**
     * @return int
     */
    public function getQuoteIdFromUrl(): int
    {
        return (int)$this->request->getParam('quote_id');
    }
}
