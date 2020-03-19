<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\ResponseInterface;

/**
 * PagSeguro Gateway
 *
 * @link https://pagseguro.uol.com.br/v2/guia-de-integracao/index.html
 *
 * @method ResponseInterface authorize(array $options = [])
 * @method ResponseInterface completeAuthorize(array $options = [])
 * @method ResponseInterface capture(array $options = [])
 * @method ResponseInterface refund(array $options = [])
 * @method ResponseInterface void(array $options = [])
 * @method ResponseInterface createCard(array $options = [])
 * @method ResponseInterface updateCard(array $options = [])
 * @method ResponseInterface deleteCard(array $options = [])
 */

class Gateway extends AbstractGateway
{
    public const version = '2';

    public function getName()
    {
        return 'PagSeguro';
    }

    public function getDefaultParameters()
    {
        return [
            'email' => '',
            'token' => '',
            'sandbox' => false,
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

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = [])
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\RefundRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\CompletePurchaseRequest', $parameters);
    }

    public function findTransaction(array $parameters = []) : Message\FindTransactionRequest
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\FindTransactionRequest', $parameters);
    }

    public function transactionSearch(array $parameters = []) : Message\TransactionSearchRequest
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\TransactionSearchRequest', $parameters);
    }

    public function fetchNotification(array $parameters = [])
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\FetchNotificationRequest', $parameters);
    }
}
