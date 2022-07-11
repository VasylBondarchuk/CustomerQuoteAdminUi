<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;


/**
 *
 */
class EditQuoteItem extends Action
{

    private $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context                   $context,
        PageFactory               $resultPageFactory,
        LoggerInterface           $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
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
        $quoteItemId = (int)$this->getRequest()->getParam('quote_item_id');

        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->getConfig()->getTitle()->prepend(__("Edit Quote Item # $quoteItemId"));
        return $resultPage;
    }
}
