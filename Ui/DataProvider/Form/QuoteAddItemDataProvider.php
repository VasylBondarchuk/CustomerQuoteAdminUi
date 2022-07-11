<?php
declare(strict_types=1);

namespace CustomerQuote\CustomerQuoteAdminUi\Ui\DataProvider\Form;

use Magento\Framework\App\Request\Http;
use Magento\Ui\DataProvider\AbstractDataProvider;
use CustomerQuote\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\CollectionFactory as QuoteItemsCollectionFactory;


/**
 * Data provider for Add Product by SKU form
 */
class QuoteAddItemDataProvider extends AbstractDataProvider
{
    /** @var array */
    private array $loadedData;

    /**
     * @var Http
     */
    private Http $request;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param QuoteItemsCollectionFactory $quoteItemsCollectionFactory
     * @param Http $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        QuoteItemsCollectionFactory $quoteItemsCollectionFactory,
        Http $request,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $quoteItemsCollectionFactory->create();
        $this->request = $request;
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
        $this->addQuoteIdFromUrl();
        return $this->loadedData;
    }

    /**
     * @return void
     */
    public function addQuoteIdFromUrl()
    {
        $this->loadedData[$this->getQuoteItemIdFromUrl()][$this->requestFieldName]
            = $this->getQuoteItemIdFromUrl();
    }

    /**
     * @return int
     */
    public function getQuoteItemIdFromUrl(): int
    {
        return (int)$this->request->getParam($this->requestFieldName);
    }
}
