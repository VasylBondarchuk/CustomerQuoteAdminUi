<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsRepositoryInterface;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems as QuoteItemResource;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\CollectionFactory;
use Training\CustomerQuoteAdminUi\Model\QuoteItemsFactory as QuoteItemModelFactory;
use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsInterface;
use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsSearchResultsInterfaceFactory;


/**
 *
 */
class QuoteItemsRepository implements QuoteItemsRepositoryInterface
{
    /**
     * @var QuoteItemResource
     */
    private QuoteItemResource $resource;

    /**
     * @var QuoteItemsFactory
     */
    private $quoteItemFactory;

    /**
     * @var CollectionFactory
     */
    private $quoteItemCollectionFactory;

    /**
     * @var QuoteItemsSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param QuoteItemResource $resource
     * @param QuoteItemsFactory $quoteItemFactory
     * @param CollectionFactory $quoteItemCollectionFactory
     * @param QuoteItemsSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        QuoteItemResource $resource,
        QuoteItemModelFactory $quoteItemFactory,
        CollectionFactory $quoteItemCollectionFactory,
        QuoteItemsSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->quoteItemFactory = $quoteItemFactory;
        $this->quoteItemCollectionFactory = $quoteItemCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param QuoteItemsInterface $quoteItem
     * @return QuoteItemsInterface
     * @throws CouldNotSaveException
     */
    public function save(QuoteItemsInterface $quoteItem): QuoteItemsInterface
    {
        try {
            $this->resource->save($quoteItem);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the feedback: %1', $exception->getMessage()),
                $exception
            );
        }
        return $quoteItem;
    }

    /**
     * @param int $quoteItemId
     * @return QuoteItemsInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $quoteItemId): QuoteItemsInterface
    {
        $quoteItem = $this->quoteItemFactory->create();
        $this->resource->load($quoteItem, $quoteItemId);
        if (!$quoteItem->getId()) {
            throw new NoSuchEntityException(__('Quote item with id "%1" does not exist.', $quoteItemId));
        }
        return $quoteItem;
    }

    /**
     * @param int $quoteId
     * @return QuoteItemsInterface
     * @throws NoSuchEntityException
     */
    public function getByQuoteId(int $quoteId): QuoteItemsInterface
    {
        $quoteItem = $this->quoteItemFactory->create();
        $this->resource->load($quoteItem, $quoteId);
        if (!$quoteItem->getId()) {
            throw new NoSuchEntityException(__('Quote item with id "%1" does not exist.', $quoteId));
        }
        return $quoteItem;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsSearchResultsInterface|mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->quoteItemCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param QuoteItemsInterface $quoteItem
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(QuoteItemsInterface $quoteItem): bool
    {
        try {
            $this->resource->delete($quoteItem);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the feedback: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param int $quoteItemId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $quoteItemId): bool
    {
        return $this->delete($this->getById($quoteItemId));
    }
}
