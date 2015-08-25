<?php

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * PagSeguro Response
 */
class PurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['error']) ? false : true;
    }
    
    public function isRedirect()
    {
        return true;
    }
    
    public function getRedirectUrl()
    {
        $request = $this->getRequest();
        return sprintf('%s/%s/payment.html?code=%s', 
                       str_replace('ws.', '', $request->getEndpoint()),
                       trim($request->getResource(), '/'),
                       $this->data['code']);
    }
}
