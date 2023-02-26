<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Controller\ResultFactory;
use Training\CustomerQuoteAdminUi\Model\UpdateQuote;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteRepositoryInterface;

/**
 *
 */
class ViewQuote extends Action {

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var UpdateQuote
     */
    private UpdateQuote $updateQuote;

    /**
     * 
     * @var QuoteRepositoryInterface
     */
    protected $resultFactory;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var RequestInterface
     */
    private QuoteRepositoryInterface $quoteRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param UpdateQuote $updateQuote
     * @param LoggerInterface $logger
     */
    public function __construct(
            Context $context,
            PageFactory $resultPageFactory,
            UpdateQuote $updateQuote,
            LoggerInterface $logger,
            ResultFactory $resultFactory,
            RequestInterface $request,
            QuoteRepositoryInterface $quoteRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->updateQuote = $updateQuote;
        $this->logger = $logger;
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->quoteRepository = $quoteRepository;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @throws LocalizedException
     */
    public function execute() {
        $quoteId = (int) $this->request->getParam('quote_id');
        if (!$this->isExistingQuote($quoteId)) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('quote/index/index/');
            return $resultRedirect;
        }
        if (!$this->updateQuote->isQuoteOpenForEditing($this->updateQuote->getQuoteIdFromUrl())) {
            $this->messageManager->addErrorMessage(__('This quote is currently locked for editing.
                It will become available once released by the buyer.'));
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Quote #%1", $quoteId));
        return $resultPage;
    }

    private function isExistingQuote(int $quoteId): bool {        
        try {
            $this->quoteRepository->getById($quoteId);
            $existing = true;
        } catch (NoSuchEntityException $e) {
            $this->logger->error($e->getLogMessage());
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('quote/index/index/');
            $existing = false;            
        }
        return $existing;
    }
}
