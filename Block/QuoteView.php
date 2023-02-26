<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\User\Model\ResourceModel\User as UserResourceModel;
use Magento\User\Model\UserFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteInterface;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\Quote\Collection;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\Quote\CollectionFactory;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteRepositoryInterface;

class QuoteView extends \Magento\Framework\View\Element\Template
{ 
    
    const DEFAULT_SORT_ORDER = 'desc';
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var UserFactory
     */
    protected UserFactory $userFactory;

    /**
     * @var UserResourceModel
     */
    protected UserResourceModel $resourceModel;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;
    
    /**
     * 
     * @var RequestInterface
     */
    private RequestInterface $request;
    
    /**
     * 
     * @var CustomerSession
     */
    private CustomerSession $customerSession;
    
    /**
     * 
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customer;
    
    
    private QuoteRepositoryInterface $quoteRepository;
    
    /**
     * 
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param UserFactory $userFactory
     * @param UserResourceModel $resourceModel
     * @param StoreManagerInterface $storeManager
     * @param RequestInterface $request
     * @param CustomerSession $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param array $data
     */
    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        UserFactory $userFactory,
        UserResourceModel $resourceModel,
        StoreManagerInterface $storeManager,
        RequestInterface $request,
        CustomerSession $customerSession,
        CustomerRepositoryInterface $customerRepository,
        QuoteRepositoryInterface $quoteRepository,   
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->userFactory = $userFactory;
        $this->resourceModel = $resourceModel;
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->customerSession = $customerSession;
        $this->customer = $customerRepository;
        $this->quoteRepository = $quoteRepository;
    }   
    
    /**
     * 
     * @return Collection
     */
    public function getCollection()
    {  
        return $this->collectionFactory->create()            
            ->addFieldToFilter(QuoteInterface::QUOTE_AUTHOR_ID, $this->getCustomerId())            
            ->setOrder(QuoteInterface::QUOTE_CREATION_TIME, self::DEFAULT_SORT_ORDER);
    }
    
    /**
     * 
     * @return type
     */
    private function getCustomerId() {
        return (int)$this->customerSession->getCustomerId();
    }
    
    /**
     * @param int $customerId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomerFullNameById(): string
    {
        $customerId = $this->getCustomerId();
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
    
    /**
     * 
     * @param QuoteInterface $quote
     * @return type
     */
    public function getViewUrl(QuoteInterface $quote) : string
    {
        return $this->getUrl('quote/index/view', ['quote_id' => $quote->getQuoteId()]);
    }
    
     /**
     * 
     * @param QuoteInterface $quote
     * @return type
     */
    public function getQuote() : QuoteInterface
    {
        $quoteId = (int)($this->request->get(self::REQUEST_FIELD_NAME));
        return $this->quoteRepository->getById($quoteId);
    }
}