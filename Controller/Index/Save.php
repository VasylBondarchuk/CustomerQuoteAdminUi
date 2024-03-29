<?php
declare(strict_types=1);

namespace Training\CustomerQuoteAdminUi\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Checkout\Model\Session as CheckoutSession;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteRepositoryInterface;
use Training\CustomerQuoteAdminUi\Api\Data\QuoteItems\QuoteItemsRepositoryInterface;
use Training\CustomerQuoteAdminUi\Model\QuoteFactory;
use Training\CustomerQuoteAdminUi\Model\QuoteItemsFactory;
use Training\CustomerQuoteAdminUi\Api\Data\Quote\QuoteInterface;

/**
 * Saves new feedback
 */
class Save implements HttpGetActionInterface, HttpPostActionInterface {

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;

    /**
     * 
     * @var QuoteFactory
     */
    private QuoteFactory $quoteFactory;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * 
     * @var UrlInterface
     */
    private UrlInterface $urlInterface;

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * 
     * @var QuoteRepositoryInterface
     */
    private QuoteRepositoryInterface $quoteRepository;

    /**
     * 
     * @var CheckoutSession
     */
    protected CheckoutSession $checkoutSession;

    /**
     * 
     * @var CustomerSession
     */
    private CustomerSession $customerSession;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * 
     * @param Session $checkoutSession
     * @param ManagerInterface $messageManager
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param FeedbackFactory $feedbackFactory
     * @param FeedbackEmailNotification $email
     * @param UrlInterface $urlInterface
     * @param ScopeConfigInterface $scopeConfig
     * @param QuoteRepositoryInterface $quoteRepository
     * @param Session $customerSession
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
            CheckoutSession $checkoutSession,
            ManagerInterface $messageManager,
            ResultFactory $resultFactory,
            RequestInterface $request,
            UrlInterface $urlInterface,
            ScopeConfigInterface $scopeConfig,
            QuoteFactory $quoteFactory,
            QuoteRepositoryInterface $quoteRepository,
            QuoteItemsFactory $quoteItemsFactory,
            QuoteItemsRepositoryInterface $quoteItemsRepository,
            CustomerSession $customerSession,
            StoreManagerInterface $storeManager
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->messageManager = $messageManager;
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->urlInterface = $urlInterface;
        $this->scopeConfig = $scopeConfig;
        $this->quoteFactory = $quoteFactory;
        $this->quoteRepository = $quoteRepository;
        $this->quoteItemsFactory = $quoteItemsFactory;
        $this->quoteItemsRepository = $quoteItemsRepository;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
    }

    /**
     * 
     * @return type
     */
    public function execute() {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/history');
        $post = $this->request->getPostValue();
        if ($post) {
            try {
                // Save data
                $quote = $this->quoteFactory->create();
                $this->saveQuote($quote, $post);
                $this->saveQuoteItems($quote);

                $this->messageManager->addSuccessMessage(
                        __('Thank you for submitting your quote.')
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                        __('An error occurred while processing your form. Please try again later.')
                );
                $resultRedirect->setPath('quote/index/history');
            }
        }
        return $resultRedirect;
    }

    private function saveQuote(QuoteInterface $quote, array $post) {
        $quote->setData($post)
              ->setQuoteUpdateTime(date("Y-m-d H:i:s"))
              ->setQuoteAuthorId($this->getCustomerId())
              ->setQuoteStatus('New');
        $this->quoteRepository->save($quote);
    }

    private function saveQuoteItems(QuoteInterface $quote) {
        foreach ($this->getProductsInQuote() as $product) {
            $quoteItem = $this->quoteItemsFactory->create();
            $quoteItem->setQuoteId($quote->getQuoteId());
            $quoteItem->setProductId((int) $product->getProductId());
            $quoteItem->setProposedQty($product->getQty());
            $quoteItem->setProposedPrice((float) $product->getBasePrice());
            $this->quoteItemsRepository->save($quoteItem);
        }
    }

    private function getCustomerId(): int {
        return (int) $this->customerSession->getCustomerId();
    }

    private function getProductsInQuote(): array {
        return $this->checkoutSession->getQuote()->getAllVisibleItems();
    }

}
