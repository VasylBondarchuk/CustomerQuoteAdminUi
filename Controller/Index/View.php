<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteRepositoryInterface;

/**
 * View a negot. quote
 */
class View implements HttpGetActionInterface {

    const REQUEST_FIELD_NAME = 'quote_id';

    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var RequestInterface
     */
    private QuoteRepositoryInterface $quoteRepository;

    public function __construct(
            PageFactory $pageFactory,
            RequestInterface $request,
            QuoteRepositoryInterface $quoteRepository
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute() {
        $quoteId = (int)($this->request->get(self::REQUEST_FIELD_NAME));
        $quoteName = $this->getQuoteNameById($quoteId);
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->prepend(__('Quote %1', $quoteName));
        return $page;
    }
    
    private function getQuoteNameById(int $quoteId) : ?string{
        return $this->quoteRepository->getById($quoteId)->getQuoteName();
    }

}
