<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use function http_build_query;
use function simplexml_load_string;
use function sprintf;
use const LIBXML_NOCDATA;

class CompletePurchaseRequest extends AbstractRequest
{
    protected $resource = 'transactions';

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

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function sendData($data)
    {
        $url = sprintf(
            '%s/%s/%s?%s',
            $this->getEndpoint(),
            $this->getResource(),
            $this->getNotificationCode(),
            http_build_query($data, '', '&')
        );

        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $url);
        $xml          = simplexml_load_string($httpResponse->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return $this->createResponse($this->xml2array($xml));
    }
}
