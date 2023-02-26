<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

use Training\CustomerQuoteAdminUi\Model\UpdateQuote;

/**
 *
 */
class Open extends Action
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
            $this->updateQuote->changeQuoteStatusToOpen();
            $this->updateQuote->changeQuoteUpdateTime();
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getLogMessage());
        }
        return $resultRedirect->setPath(
            'quote/index/viewquote/',
            ['quote_id' => $this->updateQuote->getQuoteIdFromUrl()]);
    }
}

