<?php

namespace Omnipay\PagSeguro\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://ws.pagseguro.uol.com.br/v2';
    protected $sandboxEndpoint = 'https://ws.sandbox.pagseguro.uol.com.br/v2';
    protected $resource = '';

    public function getEmail()
    {
        return $this->getParameter('email');
    }
    
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getToken()
    {
        return $this->getParameter('token');
    }

    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }
    
    public function getSandbox()
    {
        return $this->getParameter('sandbox');
    }

    public function setSandbox($value)
    {
        return $this->setParameter('sandbox', $value);
    }
    
    public function getData()
    {
        $this->validate('email', 'token');

        return [
            'email' => $this->getEmail(),
            'token' => $this->getToken()
        ];
    }
    
    public function getResource()
    {
        return $this->resource;
    }
    
    public function sendData($data)
    {
        $url = sprintf('%s/%s', 
                       $this->getEndpoint(), 
                       trim($this->getResource(), '/'));
                       
        $headers = [
            'headers' => ['Content-Type' => 'x-www-form-urlencoded; charset=UTF-8']
        ];

        $httpResponse = $this->httpClient->post($url, $headers, $data)->send();
        $xml = $httpResponse->xml();
        
        return $this->createResponse($this->xml2array($xml));
    }
    
    protected function xml2array($xml) 
    {
        $arr = [];

        foreach ($xml as $element) {
            $tag = $element->getName();
            $e   = get_object_vars($element);
        
            if (!empty($e)) {
                $arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
                continue;
            }
         
            $arr[$tag] = trim($element);
        }

        return $arr;
    }

    public function getEndpoint()
    {
        return $this->getSandbox() ? $this->sandboxEndpoint : $this->endpoint;
    }
}
