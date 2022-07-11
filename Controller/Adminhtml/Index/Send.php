<?php

namespace CustomerQuote\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

use CustomerQuote\CustomerQuoteAdminUi\Model\UpdateQuote;

/**
 *
 */
class Send extends Action
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var UpdateQuote
     */
    private UpdateQuote $updateQuote;


    public function __construct(
        Context                       $context,
        UpdateQuote               $updateQuote,
        LoggerInterface               $logger
    ) {
        $this->updateQuote = $updateQuote;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $this->updateQuote->changeQuoteStatusToSubmitted();
            $this->updateQuote->changeQuoteUpdateTime();
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getLogMessage());
        }
        return $resultRedirect->setRefererOrBaseUrl();
    }
}

