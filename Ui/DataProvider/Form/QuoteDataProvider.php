<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Ui\DataProvider\Form;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\Quote\CollectionFactory as QuoteCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Data provider for quote's items form
 */
class QuoteDataProvider extends AbstractDataProvider
{
    /** @var array */
    private array $loadedData;

    private CustomerRepositoryInterface $customer;

    private LoggerInterface $logger;

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        QuoteCollectionFactory $quoteCollectionFactory,
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface $logger,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $quoteCollectionFactory->create();
        $this->customer = $customerRepository;
        $this->logger = $logger;
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
            $this->replaceQuoteAuthorIdByAuthorName($item);
        }

        return $this->loadedData;
    }

    private function replaceQuoteAuthorIdByAuthorName($item)
    {
        $this->loadedData[$item->getId()]['quote_author_id'] =
            $this->getCustomerFullNameById((int)$this->loadedData[$item->getId()]['quote_author_id']);
    }

    /**
     * @param int $customerId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getCustomerFullNameById(int $customerId): string
    {
        try {
            $customerFullName =
                $this->customer->getById($customerId)->getFirstname(). ' ' .
                $this->customer->getById($customerId)->getLastname();
        } catch (NoSuchEntityException $e) {
            $customerFullName = '';
            $this->logger->error($e->getLogMessage());
        }
        return $customerFullName;
    }
}
