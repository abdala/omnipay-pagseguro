<?php

namespace Omnipay\PagSeguro\Message;

class FindTransactionRequest extends AbstractRequest
{
    protected $resource = "transactions";

    public function getTransactionID()
    {
        return $this->getParameter('transactionId');
    }

    public function setTransactionID($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    protected function createResponse($data)
    {
        return $this->response = new FindTransactionResponse($this, $data);
    }

    public function sendData($data)
    {
        $url = sprintf('%s/%s/%s?%s', $this->getEndpoint(),
                                      $this->getResource(),
                                      $this->getTransactionID(),
                                      http_build_query($data, '', '&'));

        $httpResponse = $this->httpClient->get($url)->send();
        $xml = $httpResponse->xml();

        return $this->createResponse($this->xml2array($xml));
    }
}
