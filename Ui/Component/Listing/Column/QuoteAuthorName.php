<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Ui\Component\Listing\Column;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Psr\Log\LoggerInterface;

/**
Displays question text by its question_id in the 'Answers Manager' grid
 */
class QuoteAuthorName extends Column
{
    private CustomerRepositoryInterface $customer;

    private LoggerInterface $logger;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface $logger,
        array $components = [],
        array $data = []
    ) {
        $this->customer = $customerRepository;
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
                $item[$this->getData('name')] = $this->getCustomerFullNameById((int)$item['quote_author_id']);
            }
        }
        return $dataSource;
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
