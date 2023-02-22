<?php

declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteRepositoryInterface;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\Quote\CollectionFactory;


class MassStatus extends Action implements HttpPostActionInterface
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected Filter $filter;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;


    private QuoteRepositoryInterface $quoteRepository;

    /**
     * @var LoggerInterface
     */
    private ?LoggerInterface $logger;

    public function __construct(
        Context                   $context,
        Filter                    $filter,
        CollectionFactory         $collectionFactory,
        QuoteRepositoryInterface  $quoteRepository,
        LoggerInterface           $logger = null
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->quoteRepository = $quoteRepository;
        $this->logger = $logger;
    }

    /**
     * Mass Delete Action
     *
     * @return Redirect
     * @throws LocalizedException
     */


    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $quoteStatus = 0;
        $quoteStatusError = 0;
        $status = $this->getRequest()->getParam('status');

        foreach ($collection->getItems() as $quote) {
            try {
                $this->quoteRepository->save($quote->setQuoteStatus($status));
                $quoteStatus++;
            } catch (LocalizedException $exception) {
                $this->logger->error($exception->getLogMessage());
                $quoteStatusError++;
            }
        }

        if ($quoteStatus) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been updated.', $quoteStatus)
            );
        }

        if ($quoteStatusError) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been updated. Please see server logs for more details.',
                    $quoteStatusError
                )
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('quote/index/index/');
    }
}
