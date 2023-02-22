<?php

namespace Training\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

use Training\CustomerQuoteAdminUi\Model\UpdateQuote;

/**
 *
 */
class ViewQuoteDetails extends Action
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
     * @param UpdateQuote $updateQuote
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context                   $context,
        PageFactory               $resultPageFactory,
        UpdateQuote               $updateQuote,
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

        if(!$this->updateQuote->isQuoteOpenForEditing($this->updateQuote->getQuoteIdFromUrl()))
        {
            $this->messageManager->addErrorMessage(__('This quote is currently locked for editing.
                It will become available once released by the buyer.'));
        }

        $resultPage = $this->resultPageFactory->create();

        $quoteId = $this->updateQuote->getQuoteIdFromUrl();
        $resultPage->getConfig()->getTitle()->prepend(__("Quote # $quoteId"));
        return $resultPage;
    }
}
