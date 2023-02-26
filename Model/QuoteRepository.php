<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteRepositoryInterface;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\Quote as QuoteResource;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\Quote\CollectionFactory;
use Training\CustomerQuoteAdminUi\Model\QuoteFactory as QuoteModelFactory;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteInterface;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteSearchResultsInterfaceFactory;


/**
 *
 */
class QuoteRepository implements QuoteRepositoryInterface
{
    /**
     * @var QuoteResource
     */
    private QuoteResource $resource;

    /**
     * @var QuoteFactory
     */
    private $quoteFactory;

    /**
     * @var CollectionFactory
     */
    private $quoteCollectionFactory;

    /**
     * @var QuoteSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param QuoteResource $resource
     * @param QuoteFactory $quoteFactory
     * @param CollectionFactory $quoteCollectionFactory
     * @param QuoteSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        QuoteResource $resource,
        QuoteModelFactory $quoteFactory,
        CollectionFactory $quoteCollectionFactory,
        QuoteSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->quoteFactory = $quoteFactory;
        $this->quoteCollectionFactory = $quoteCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param QuoteInterface $quote
     * @return QuoteInterface
     * @throws CouldNotSaveException
     */
    public function save(QuoteInterface $quote): QuoteInterface
    {
        try {
            $this->resource->save($quote);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the feedback: %1', $exception->getMessage()),
                $exception
            );
        }
        return $quote;
    }

    /**
     * @param int $quoteId
     * @return QuoteInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $quoteId): QuoteInterface
    {
        $quote = $this->quoteFactory->create();
        $this->resource->load($quote, $quoteId);
        if (!$quote->getId()) {
            throw new NoSuchEntityException(__('Quote item with id "%1" does not exist.', $quoteId));
        }
        return $quote;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->quoteCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param QuoteInterface $quote
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(QuoteInterface $quote): bool
    {
        try {
            $this->resource->delete($quote);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the feedback: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param int $quoteId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $quoteId): bool
    {
        return $this->delete($this->getById($quoteId));
    }
}
