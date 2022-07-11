<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use CustomerQuote\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsRepositoryInterface;
use CustomerQuote\CustomerQuoteAdminUi\Model\QuoteItemsFactory;

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
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param QuoteItemsRepositoryInterface $quoteItemsRepository
     * @param QuoteItemsFactory $quoteItemsFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context                   $context,
        QuoteItemsRepositoryInterface $quoteItemsRepository,
        LoggerInterface           $logger
    ) {
        $this->quoteItemsRepository = $quoteItemsRepository;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $this->deleteQuoteItem();
        $this->messageManager->addSuccessMessage(__('You deleted the quote item.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setRefererOrBaseUrl();
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
}
