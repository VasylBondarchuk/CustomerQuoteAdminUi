<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

use CustomerQuote\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsRepositoryInterface;
use CustomerQuote\CustomerQuoteAdminUi\Api\Data\Quote\QuoteRepositoryInterface;
use CustomerQuote\CustomerQuoteAdminUi\Model\UpdateQuote;

/**
 *
 */
class EditQuoteItem extends Action
{
    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var UpdateQuote
     */
    private UpdateQuote $updateQuote;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context                   $context,
        PageFactory               $resultPageFactory,
        QuoteItemsRepositoryInterface $quoteItemsRepository,
        QuoteRepositoryInterface $quoteRepository,
        UpdateQuote $updateQuote,
        LoggerInterface           $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->updateQuote = $updateQuote;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @throws LocalizedException
     */
    public function execute()
    {
        if($this->updateQuote->isQuoteOpenForEditing($this->getQuoteId())) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__("Edit Quote Item #".$this->getQuoteItemId()));
            return $resultPage;
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setRefererOrBaseUrl();
    }

    public function getQuoteId(): int
    {
        return $this->updateQuote->getQuoteIdByQuoteItemId();
    }

    public function getQuoteItemId(): int
    {
        return $this->updateQuote->getQuoteItemIdFromUrl();
    }
}
