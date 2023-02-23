<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\Grid;

use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\CollectionFactory as QuoteItemsCollectionFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class to prepare collection for admin promotion list page
 */
class Collection extends SearchResult
{
    private  $quoteItemsCollection;


    public function __construct(
        QuoteItemsCollectionFactory $quoteItemsCollectionFactory,
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        Http $request,
        string $mainTable = "training_negotiable_quote_items",
        $resourceModel = null,
        $identifierName = null,
        $connectionName = null
    ) {
        $this->quoteItemsCollection = $quoteItemsCollectionFactory;

        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $mainTable,
            $resourceModel,
            $identifierName,
            $connectionName
        );
    }
}
