<?php

declare(strict_types=1);

namespace CustomerQuote\CustomerQuoteAdminUi\Ui\Component\Listing\Column;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 Displays question text by its question_id in the 'Answers Manager' grid
 */
class ProductName extends Column
{
    private $productRepository;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ProductRepository $productRepository,
        array $components = [],
        array $data = []
    ) {
        $this->productRepository = $productRepository;
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
                $item[$this->getData('name')] = $this->getProductNameById((int)$item['product_id']);
            }
        }
        return $dataSource;
    }

    private function getProductNameById(int $productId): string
    {
        return $this->productRepository->getById($productId)->getName();
    }
}
