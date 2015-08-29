<?php
/**
 * PagSeguro Abstract Request
 */

namespace Omnipay\PagSeguro\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    protected $resource = "transactions/notifications";
    
    public function getNotificationCode()
    {
        return $this->getParameter('notificationCode');
    }
    
    public function setNotificationCode($value)
    {
        return $this->setParameter('notificationCode', $value);
    }
    
    protected function createResponse($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
    
    public function sendData($data)
    {
        $url = sprintf('%s/%s/%s?%s', $this->getEndpoint(), 
                                      $this->getResource(),
                                      $this->getNotificationCode(), 
                                      http_build_query($data, '', '&'));
                                   
        $httpResponse = $this->httpClient->get($url)->send();
        $xml = $httpResponse->xml();
        
        return $this->createResponse($this->xml2array($xml));
    }
}
