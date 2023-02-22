<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Ui\DataProvider\Listing;

use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\CollectionFactory as QuoteItemsCollectionFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\Request\Http;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

/**
 * Data provider for quote's items form
 */
class QuoteItemsDataProvider extends AbstractDataProvider
{
    /** @var array */
    private array $loadedData;

    /** @var array */
    private $quotesItemsCollection;

    private Http $request;

    private $productRepository;

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        QuoteItemsCollectionFactory $quotesItemsCollectionFactory,
        Http $request,
        ProductRepository $productRepository,

        array $meta = [],
        array $data = []
    ) {
        $this->request = $request;
        $this->collection = $quotesItemsCollectionFactory->create();
        $this->productRepository = $productRepository;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
        }
        return $this->loadedData;
    }

    private function replaceProductIdBySku($item)
    {
        $this->loadedData[$item->getId()]['product_id'] =
            $this->getProductSkuById((int)$this->loadedData[$item->getId()]['product_id']);
    }

    private function getProductSkuById(int $productId): string
    {
        return $this->productRepository->getById($productId)->getSku();
    }
}
