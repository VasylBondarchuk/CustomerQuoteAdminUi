<?php

declare(strict_types=1);

namespace CustomerQuote\CustomerQuoteAdminUi\Ui\Component\Listing\Column;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Psr\Log\LoggerInterface;


/**
 Displays question text by its question_id in the 'Answers Manager' grid
 */
class ProductSku extends Column
{
    private $productRepository;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ProductRepository $productRepository,
        LoggerInterface               $logger,
        array $components = [],
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->logger = $logger;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Displays product sku by its id
     *
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                $item[$this->getData('name')] = $this->getProductSkuById((int)$item['product_id']);
            }
        }
        return $dataSource;
    }

    private function getProductSkuById(int $productId): string
    {
        try {
            $productSku = $this->productRepository->getById($productId)->getSku();
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getLogMessage());
            $productSku = '';
        }
        return $productSku;
    }
}
