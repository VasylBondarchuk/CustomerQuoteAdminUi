<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Ui\DataProvider\Form;

use Magento\Framework\App\Request\Http;
use Magento\Catalog\Model\ProductRepository;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\CollectionFactory as QuoteItemsCollectionFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

/**
 * Data provider for quote's items form
 */
class QuoteItemDataProvider extends AbstractDataProvider
{
    /** @var array */
    private $loadedData;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * @var Http
     */
    private Http $request;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var PriceHelper
     */
    private $priceHelper;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param QuoteItemsCollectionFactory $quoteItemsCollectionFactory
     * @param ProductRepository $productRepository
     * @param Http $request
     * @param LoggerInterface $logger
     * @param PriceHelper $priceHelper
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        QuoteItemsCollectionFactory $quoteItemsCollectionFactory,
        ProductRepository $productRepository,
        Http $request,
        LoggerInterface $logger,
        PriceHelper $priceHelper,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $quoteItemsCollectionFactory->create();
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->logger = $logger;
        $this->priceHelper = $priceHelper;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
            $this->showCatalogPriceByProductId($item);
            $this->replaceProductIdBySku($item);
        }
        return $this->loadedData;
    }

    /**
     * @param $item
     * @return void
     */
    public function replaceProductIdBySku($item)
    {
        $this->loadedData[$item->getId()]['product_id'] =
            $this->getProductSkuById(
                (int)$this->loadedData[$item->getId()]['product_id']
            );
    }

    /**
     * @param $item
     * @return void
     */
    public function showCatalogPriceByProductId($item)
    {
        $this->loadedData[$item->getId()]['product_catalog_price'] =
            $this->displayCurrencySymbol(
                $this->getProductCatalogPriceById(
                    (int)$this->loadedData[$item->getId()]['product_id']
                )
            );
    }

    /**
     * @param int $productId
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductSkuById(int $productId) : string
    {
        return $this->productRepository->getById($productId)->getSku();
    }

    /**
     * @param int $productId
     * @return float|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductCatalogPriceById(int $productId): ?float
    {
        return (float)$this->productRepository->getById($productId)->getPrice();
    }

    /**
     * @return int
     */
    public function getQuoteItemId(): int
    {
        return (int)$this->request->getParam('quote_id');
    }

    /**
     * @param $price
     * @return float|string
     */
    private function displayCurrencySymbol($price)
    {
        return $this->priceHelper->currency($price, true, false);
    }
}
