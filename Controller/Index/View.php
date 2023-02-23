<?php

namespace Training\CustomerQuoteAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;


/**
 *
 */
class Index extends Action
{
    /**
     *
     */
    const ADMIN_RESOURCE = 'Training_CustomerQuoteAdminUi::quote';

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                   $context,
        PageFactory               $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('Training_CustomerQuoteAdminUi::quote')
            ->addBreadcrumb(__('Negotiated Quotes'), __('Negotiated Quotes'))
            ->getConfig()->getTitle()->prepend(__('Negotiated Quotes'));
        return $resultPage;
    }
}
