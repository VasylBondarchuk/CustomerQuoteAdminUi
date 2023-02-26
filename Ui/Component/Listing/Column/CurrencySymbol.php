<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Ui\Component\Listing\Column;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

/**
 Displays question text by its question_id in the 'Answers Manager' grid
 */
class CurrencySymbol extends Column
{
    private $priceHelper;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        PriceHelper $priceHelper,
        array $components = [],
        array $data = []
    ) {
        $this->priceHelper = $priceHelper;
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
                $item[$this->getData('name')] = $this->displayCurrencySymbol((int)$item['proposed_price']);
            }
        }
        return $dataSource;
    }

    private function displayCurrencySymbol($price)
    {
        return $this->priceHelper->currency($price, true, false);
    }
}
