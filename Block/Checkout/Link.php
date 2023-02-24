<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Training\CustomerQuoteAdminUi\Block\Checkout;

class Link extends \Magento\Framework\View\Element\Template
{ 
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context     
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,           
        array $data = []
    ) {        
        parent::__construct($context, $data); 
    }

    /**
     * @return string
     */
    public function getRequestQuoteUrl()
    {
        return $this->getUrl('checkout/cart', ['_secure' => true]);
    }
    
     /**
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('quote/index/save', ['_secure' => true]);
    }


}