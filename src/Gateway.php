<?php

namespace Omnipay\PagSeguro;

use Omnipay\Common\AbstractGateway;

/**
 * MercadoPago Gateway
 *
 * @link https://pagseguro.uol.com.br/v2/guia-de-integracao/index.html
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
    /*
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('Omnipay\\PagSeguro\\Message\\CompletePurchaseRequest', $parameters);
    }
    */
}
