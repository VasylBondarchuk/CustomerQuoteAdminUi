<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Training\CustomerQuoteAdminUi\Block\Checkout;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Link extends Template
{ 
     /**
     * 
     * @var RequestInterface
     */
    private RequestInterface $request;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context     
     * @param array $data
     */
    public function __construct(
        Context $context,
        RequestInterface $request,    
        array $data = []
    ) {        
        parent::__construct($context, $data);
        $this->request = $request;
    }    
    
    /**
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('quote/index/save', ['_secure' => true]);
    }
    
    /**
     * @return string
     */
    public function isQuoteRequested() : bool
    {
        return (bool)$this->request->getParam('quote');
    }
    
     /**
     * @return string
     */
    public function getRequestQuoteUrl() 
    {        
        return  $this->getUrl('checkout/cart', ['_secure' => true, 'quote'=>!$this->isQuoteRequested()]); 
                
           
    }  
}
