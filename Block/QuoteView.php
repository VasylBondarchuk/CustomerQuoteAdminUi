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
use Magento\Catalog\Api\ProductRepositoryInterface;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\Collection;
use Training\CustomerQuoteAdminUi\Model\ResourceModel\QuoteItems\CollectionFactory;
use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsRepositoryInterface;
use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsInterface;

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
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    
        
    /**
     * 
     * @var QuoteRepositoryInterface
     */
    private QuoteItemsRepositoryInterface $quoteRepository;
    
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
     * @param QuoteItemsRepositoryInterface $quoteItemsRepository
     * @param array $data
     */
    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        UserFactory $userFactory,
        UserResourceModel $resourceModel,
        StoreManagerInterface $storeManager,
        RequestInterface $request,
        ProductRepositoryInterface $productRepository,    
        QuoteItemsRepositoryInterface $quoteItemsRepository,   
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->userFactory = $userFactory;
        $this->resourceModel = $resourceModel;
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->quoteRepository = $quoteItemsRepository;
    }   
    
    /**
     * 
     * @return Collection
     */
    public function getCollection()
    {  
        return $this->collectionFactory->create()            
            ->addFieldToFilter(QuoteItemsInterface::QUOTE_ID, $this->getQuoteId()); 
    }
    
    /**
     * 
     * @return type
     */
    public function getProductSku($productId) {
        return $this->productRepository->getById($productId)->getSku();
    }
    
        /**
     * 
     * @return type
     */
    public function getProductName($productId) {
        return $this->productRepository->getById($productId)->getName();
    }
     
    
     /**
     * 
     * @param QuoteInterface $quote
     * @return type
     */
    public function getQuote() 
    {
        $quoteId = (int)($this->request->get(self::REQUEST_FIELD_NAME));
        return $this->quoteRepository->getById($quoteId);
    }
    
        
     /**
     * 
     * @param QuoteInterface $quote
     * @return type
     */
    public function getQuoteId() : int
    {
        $quoteId = (int)($this->request->get('quote_id'));
        return $quoteId;
    }
}