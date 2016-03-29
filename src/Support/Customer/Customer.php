<?php

namespace Omnipay\PagSeguro\Support\Customer;

use Omnipay\Common\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

class Customer
{
    /**
     * Internal storage of all of the card parameters.
     *
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameters;

    /**
     * Create a new object using the specified parameters
     *
     * @param array $parameters
     * @param Phone $phone
     * @param Address $address
     */
    public function __construct($parameters = null, Phone $phone = null, Address $address = null)
    {
        $this->initialize($parameters);

        $this->setPhone($phone);
        $this->setAddress($address);
    }

    /**
     * Initialize the object with parameters.
     *
     * If any unknown parameters passed, they will be ignored.
     *
     * @param array $parameters An associative array of parameters
     * @return $this
     */
    public function initialize($parameters = null)
    {
        $this->parameters = new ParameterBag;

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * Get all parameters.
     *
     * @return array An associative array of parameters.
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }

    /**
     * Get one parameter.
     *
     * @return mixed A single parameter value.
     */
    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * Set one parameter.
     *
     * @param string $key Parameter key
     * @param mixed $value Parameter value
     * @return $this
     */
    protected function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);

        return $this;
    }

    /**
     * Sets email.
     *
     * @param string $value
     * @return $this.
     */
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }


    /**
     * Sets name.
     *
     * @param string $value
     * @return $this.
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Sets cpf.
     *
     * @param string $value
     * @return $this.
     */
    public function setCPF($value)
    {
        return $this->setParameter('cpf', $value);
    }

    /**
     * Get cpf.
     *
     * @return string
     */
    public function getCPF()
    {
        return $this->getParameter('cpf');
    }

    /**
     * Sets born date.
     *
     * @param string $value
     * @return $this.
     */
    public function setBornDate($value)
    {
        return $this->setParameter('bornDate', $value);
    }

    /**
     * Get born date.
     *
     * @return string
     */
    public function getBornDate()
    {
        return $this->getParameter('bornDate');
    }

    /**
     * Sets Phone.
     *
     * @param string $value
     * @return $this.
     */
    public function setPhone($value)
    {
        if (!$value instanceof Phone) {
            $value = new Phone();
        }

        return $this->setParameter('phone', $value);
    }

    /**
     * Get Phone.
     *
     * @return Phone
     */
    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    /**
     * Sets Address.
     *
     * @param string $value
     * @return $this.
     */
    public function setAddress($value)
    {
        if (!$value instanceof Address) {
            $value = new Address();
        }

        return $this->setParameter('address', $value);
    }

    /**
     * Get Address.
     *
     * @return Address
     */
    public function getAddress()
    {
        return $this->getParameter('address');
    }
}