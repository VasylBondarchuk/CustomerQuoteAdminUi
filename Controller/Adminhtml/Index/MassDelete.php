<?php
declare(strict_types=1);

namespace CustomerQuote\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

use CustomerQuote\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsRepositoryInterface;
use CustomerQuote\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
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


    private QuoteItemsRepositoryInterface $quoteItemsRepository;

    /**
     * @var LoggerInterface
     */
    private ?LoggerInterface $logger;

    public function __construct(
        Context                   $context,
        Filter                    $filter,
        CollectionFactory         $collectionFactory,
        QuoteItemsRepositoryInterface  $quoteItemsRepository,
        LoggerInterface           $logger = null
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->quoteItemsRepository = $quoteItemsRepository;
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
        $quoteItemsDeteleted = 0;
        $quoteItemsDeteletedError = 0;

        foreach ($collection->getItems() as $quoteItem) {
            try {
                $this->quoteItemsRepository->delete($quoteItem);
                $quoteItemsDeteleted++;
            } catch (LocalizedException $exception) {
                $this->logger->error($exception->getLogMessage());
                $quoteItemsDeteletedError++;
            }
        }

        if ($quoteItemsDeteleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $quoteItemsDeteleted)
            );
        }

        if ($quoteItemsDeteletedError) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $quoteItemsDeteletedError
                )
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}
