<?php

namespace Training\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\ProductRepository;

use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsInterface;
use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsRepositoryInterface;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\CollectionFactory as QuoteItemsCollectionFactory;
use Training\CustomerQuoteAdminUi\Model\QuoteItemsFactory;

/**
 *
 */
class Save extends Action
{
    /**
     * @var QuoteItemsRepositoryInterface
     */
    private QuoteItemsRepositoryInterface $quoteItemsRepository;

    /**
     * @var QuoteItemsCollectionFactory
     */
    private QuoteItemsCollectionFactory $quoteItemscollectionFactory;

    /**
     * @var QuoteItemsFactory
     */
    private QuoteItemsFactory $quoteItemsFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * @param Context $context
     * @param QuoteItemsRepositoryInterface $quoteItemsRepository
     * @param ProductRepository $productRepository
     * @param QuoteItemsCollectionFactory $quoteItemscollectionFactory
     * @param QuoteItemsFactory $quoteItemsFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context                       $context,
        QuoteItemsRepositoryInterface $quoteItemsRepository,
        ProductRepository             $productRepository,
        QuoteItemsCollectionFactory   $quoteItemscollectionFactory,
        QuoteItemsFactory             $quoteItemsFactory,
        LoggerInterface               $logger
    ) {
        $this->quoteItemsRepository = $quoteItemsRepository;
        $this->productRepository = $productRepository;
        $this->quoteItemscollectionFactory = $quoteItemscollectionFactory;
        $this->quoteItemsFactory = $quoteItemsFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($this->getRawPostData()) {
            if($this->areAllEnteredValuesValid())
            {
                $this->saveQuoteItem($this->getProccesedPostData());
                $this->showSuccessMessage();
                return $this->redirectToViewQuoteDetailsPage($resultRedirect);
            }
            $this->showErrorMessage();
        }
        return $this->remainOnCurrentPage($resultRedirect);
    }

    /**
     * @param Redirect $resultRedirect
     * @return Redirect
     */
    private function redirectToViewQuoteDetailsPage(Redirect $resultRedirect): Redirect
    {
        return $resultRedirect->setPath(
            'quote/index/viewquotedetails/',
            ['quote_id' => $this->getQuoteId()]);
    }

    /**
     * @param Redirect $resultRedirect
     * @return Redirect
     */
    private function remainOnCurrentPage(Redirect $resultRedirect): Redirect
    {
        return $resultRedirect->setRefererOrBaseUrl();
    }

    /**
     * @param array $data
     * @return void
     */
    private function saveQuoteItem(array $data): void
    {
        try {
            $this->quoteItemsRepository->save($this->getQuoteItemsModel()->setData($data));
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getLogMessage());
        }
    }

    /**
     * @return QuoteItemsInterface
     */
    private function getQuoteItemsModel() : QuoteItemsInterface
    {
        return $this->onEditingQuoteItemPage()
            ? $this->quoteItemsRepository->getById($this->getQuoteItemId())
            : $this->quoteItemsFactory->create();
    }

    /**
     * @return int
     */
    private function getQuoteItemId(): int
    {
        return (int)$this->getRequest()->getParam('quote_item_id');
    }

    /**
     * @return array
     */
    private function getProccesedPostData() : array
    {
        return $this->replaceProductSkuByIdInPostData(
            $this->getRequest()->getPostValue()
        );
    }

    /**
     * @return array
     */
    private function getRawPostData() : array
    {
        return $this->getRequest()->getPostValue();
    }

    /**
     * @param array $postData
     * @return array
     */
    private function replaceProductSkuByIdInPostData (array $postData): array
    {
        if($this->isEnteredSkuValid()) {
            $postData[QuoteItemsInterface::PRODUCT_ID] =
                $this->getProductIdBySku($postData[QuoteItemsInterface::PRODUCT_ID]);
        }
        return $postData;
    }

    /**
     * @param string $productSku
     * @return int
     */
    private function getProductIdBySku(string $productSku) : ?int
    {
        try {
            $productId = $this->productRepository->get($productSku)->getId();
        } catch (LocalizedException $exception) {
            $productId = null;
            $this->logger->error($exception->getLogMessage());
        }
        return $productId;
    }

    /**
     * @param int $productId
     * @return string
     */
    private function getProductSkuById(int $productId) : string
    {
        try {
            $productSku = $this->productRepository->getById($productId)->getSku();
        } catch (LocalizedException $exception) {
            $productSku = '';
            $this->logger->error($exception->getLogMessage());
        }
        return $productSku;
    }

    /**
     * @return bool
     * @throws NoSuchEntityException
     */
    private function areAllEnteredValuesValid() : bool
    {
        return  $this->isEnteredSkuValid() &&
                $this->isEnteredProposedPriceValid() &&
                $this->isEnteredProposedQtyValid();
    }

    /**
     * Verifies whether the entered SKU exists
     *
     * @return bool
     */
    private function isEnteredSkuExist() : bool
    {
        try {
            $validation = (bool)$this->productRepository->get($this->getEnteredSku());
        } catch (LocalizedException $exception) {
            $validation = false;
            $this->logger->error($exception->getLogMessage());
        }
        return $validation;
    }

    /**
     * For adding new item check SKU existence and that there is no duplicate in the quote
     * For editing an existing item only SKU existence
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    private function isEnteredSkuValid() : bool
    {
        return $this->onEditingQuoteItemPage()
            ?  $this->isEnteredSkuExist()
            :  $this->isEnteredSkuExist() && $this->isEnteredSkuUniqueInQuote();
    }

    /**
     * @return bool
     * @throws NoSuchEntityException
     */
    private function isEnteredSkuUniqueInQuote() : bool
    {
        return !in_array($this->getEnteredSku(), $this->getAllSkusInQuote());
    }

    /**
     * @return bool
     */
    private function isEnteredProposedPriceValid(): bool
    {
        return $this->getRawPostData()[QuoteItemsInterface::PROPOSED_PRICE] > 0;
    }

    /**
     * @return bool
     */
    private function isEnteredProposedQtyValid(): bool
    {
        return $this->getRawPostData()[QuoteItemsInterface::PROPOSED_QTY] > 0;
    }

    /**
     * @return int
     */
    private function getQuoteId(): int
    {
        return (int)$this->getRawPostData()[QuoteItemsInterface::QUOTE_ID] ;
    }

    /**
     * @return void
     */
    private function showSuccessMessage()
    {
        $this->onEditingQuoteItemPage()
            ? $this->messageManager->addSuccessMessage(__('You edited the quote item'))
            : $this->messageManager->addSuccessMessage(__('You have added the product to the quote.'));
    }

    /**
     * @return void
     */
    private function showErrorMessage()
    {
        if(!$this->isEnteredProposedPriceValid()){
            $this->messageManager->addErrorMessage(__('Incorrect Proposed price'));
        }
        if(!$this->isEnteredProposedQtyValid()) {
            $this->messageManager->addErrorMessage(__('Incorrect Proposed Qty'));
        }
        if(!$this->isEnteredSkuExist()) {
            $this->messageManager->addErrorMessage(__('Entered SKU does not exist'));
        }
        if(!$this->isEnteredSkuUniqueInQuote() && !$this->onEditingQuoteItemPage()) {
            $this->messageManager->addErrorMessage(__('Product with the enterted SKU already exists.'));
        }
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    private function getAllSkusInQuote() : array
    {
        $quoteItemCollection = $this->quoteItemscollectionFactory->create();
        $quoteItemCollection->addFieldToFilter(
            QuoteItemsInterface::QUOTE_ID,
            array('in' => [$this->getQuoteId()])
        );
        $skusInQuote = [];
        foreach ($quoteItemCollection as $quoteItem) {
            $skusInQuote[] = $this->getProductSkuById($quoteItem->getProductId());
        }
        return $skusInQuote;
    }

    /**
     * @return bool
     */
    private function onEditingQuoteItemPage() : bool
    {
        return (bool)$this->getQuoteItemId();
    }

    /**
     * @return string
     */
    private function getEnteredSku() : string
    {
        return $this->getRawPostData()[QuoteItemsInterface::PRODUCT_ID];
    }
}

