<?php

namespace Omnipay\PagSeguro\Message;
/*
 * PagSeguro Fetch Notification Request
 *
 * https://dev.pagseguro.uol.com.br/docs/checkout-web-notificacoes
 *
 */

class FetchNotificationRequest extends AbstractRequest
{
    protected $endpoint = 'https://ws.pagseguro.uol.com.br/v3';
    protected $sandboxEndpoint = 'https://ws.sandbox.pagseguro.uol.com.br/v3';
    protected $resource = "transactions/notifications";

    public function getNotificationCode()
    {
        return $this->getParameter('notificationCode');
    }

    public function setNotificationCode($value)
    {
        return $this->setParameter('notificationCode', $value);
    }

    public function sendData($data)
    {
        $this->validate('notificationCode');

        $url = sprintf('%s/%s/%s?%s', $this->getEndpoint(),
                                      $this->getResource(),
                                      $this->getNotificationCode(),
                                      http_build_query($data, '', '&'));

        $httpResponse = $this->httpClient->get($url)->send();
        $xml = $httpResponse->xml();

        return $this->createResponse($this->xml2array($xml));
    }

    public function createResponse($data)
    {
        return $this->response = new FetchNotificationResponse($this, $data);
    }
}
