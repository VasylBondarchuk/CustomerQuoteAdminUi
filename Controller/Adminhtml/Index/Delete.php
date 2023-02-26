<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsRepositoryInterface;
use Training\CustomerQuoteAdminUi\Model\QuoteItemsFactory;
use Training\CustomerQuoteAdminUi\Model\UpdateQuote;

/**
 *
 */
class Delete extends Action
{
    /**
     * @var QuoteItemsRepositoryInterface
     */
    private QuoteItemsRepositoryInterface $quoteItemsRepository;

    /**
     * @var QuoteItemsRepositoryInterface
     */
    private UpdateQuote $updateQuote;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param Context $context
     * @param QuoteItemsRepositoryInterface $quoteItemsRepository
     * @param UpdateQuote $updateQuote
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context                   $context,
        QuoteItemsRepositoryInterface $quoteItemsRepository,
        UpdateQuote $updateQuote,
        LoggerInterface           $logger
    ) {
        $this->quoteItemsRepository = $quoteItemsRepository;
        $this->updateQuote = $updateQuote;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $quoteId = $this->updateQuote->getQuoteIdByQuoteItemId();
        $this->deleteQuoteItem();
        $this->messageManager->addSuccessMessage(__('You deleted the quote item.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $this->redirectToViewQuoteDetailsPage($resultRedirect, $quoteId);
    }

    private function deleteQuoteItem(): void
    {
        try {
            $quoteItemsModel = $this->quoteItemsRepository->getById($this->getQuoteItemsId());
            $this->quoteItemsRepository->delete($quoteItemsModel);
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getLogMessage());
        }
    }

    private function getQuoteItemsId(): int
    {
        return (int)$this->getRequest()->getParam('quote_item_id');
    }

    /**
     * @param Redirect $resultRedirect
     * @return Redirect
     */
    private function redirectToViewQuoteDetailsPage(Redirect $resultRedirect, int $quoteId): Redirect
    {
        return $resultRedirect->setPath(
            'quote/index/viewquotedetails/',
            ['quote_id' => $quoteId]);
    }
}
