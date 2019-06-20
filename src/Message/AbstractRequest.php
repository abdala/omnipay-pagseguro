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

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getHeaders()
    {
        return ['Content-Type' => 'application/x-www-form-urlencoded'];
    }

    public function sendData($data)
    {
        $url = sprintf('%s/%s?%s',
                       $this->getEndpoint(),
                       trim($this->getResource(), '/'),
                       http_build_query($data, '', '&')
                    );



        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $url, $this->getHeaders());
        $xml = simplexml_load_string($httpResponse->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return $this->createResponse($this->xml2array($xml));
    }

    protected function xml2array($xml)
    {
        $response = []; // or $result

        if (! $xml) {
            return $response;
        }

        foreach ($xml as $element) {
            $tag = $element->getName();
            $e   = get_object_vars($element);

            if (!empty($e)) {
                $response[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
                continue;
            }

            $response[$tag] = trim($element);
        }

        return $response;
    }

    public function getEndpoint()
    {
        return $this->getSandbox() ? $this->sandboxEndpoint : $this->endpoint;
    }
}
