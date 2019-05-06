<?php

namespace Omnipay\PagSeguro;

use Omnipay\Common\AbstractGateway;

/**
 * PagSeguro Gateway
 *
 * @link https://pagseguro.uol.com.br/v2/guia-de-integracao/index.html
 *
 * @method \Omnipay\Common\Message\ResponseInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface void(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\ResponseInterface deleteCard(array $options = array())
 */

class Gateway extends AbstractGateway
{
    const version = "2";

    public function getName()
    {
        return 'PagSeguro';
    }

    public function getDefaultParameters()
    {
        return [
            'email' => '',
            'token' => '',
            'sandbox' => false
        ];
    }

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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\RefundRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\CompletePurchaseRequest', $parameters);
    }

    /**
     * @return Message\FindTransactionRequest
     */
    public function findTransaction(array $parameters = array())
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\FindTransactionRequest', $parameters);
    }

    /**
     * @return Message\TransactionSearchRequest
     */
    public function transactionSearch(array $parameters = array())
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\TransactionSearchRequest', $parameters);
    }

    public function fetchNotification (array $parameters = array()) {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\FetchNotificationRequest', $parameters);
    }
}
