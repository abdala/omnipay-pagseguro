<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Support\Customer;

use Omnipay\Common\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

class Customer
{
    /**
     * Internal storage of all of the card parameters.
     *
     * @var ParameterBag
     */
    protected $parameters;

    /**
     * Create a new object using the specified parameters
     *
     * @param array $parameters
     */
    public function __construct(?array $parameters = null, ?Phone $phone = null, ?Address $address = null)
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
     *
     * @return $this
     */
    public function initialize(?array $parameters = null)
    {
        $this->parameters = new ParameterBag();

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * Get all parameters.
     *
     * @return array An associative array of parameters.
     */
    public function getParameters() : array
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
     * @param string $key   Parameter key
     * @param mixed  $value Parameter value
     *
     * @return $this
     */
    protected function setParameter(string $key, $value)
    {
        $this->parameters->set($key, $value);

        return $this;
    }

    /**
     * Sets email.
     *
     * @return $this.
     */
    public function setEmail(string $value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * Get email.
     */
    public function getEmail() : string
    {
        return $this->getParameter('email');
    }

    /**
     * Sets name.
     *
     * @return $this.
     */
    public function setName(string $value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * Get name.
     */
    public function getName() : string
    {
        return $this->getParameter('name');
    }

    /**
     * Sets cpf.
     *
     * @return $this.
     */
    public function setCPF(string $value)
    {
        return $this->setParameter('cpf', $value);
    }

    /**
     * Get cpf.
     */
    public function getCPF() : string
    {
        return $this->getParameter('cpf');
    }

    /**
     * Sets born date.
     *
     * @return $this.
     */
    public function setBornDate(string $value)
    {
        return $this->setParameter('bornDate', $value);
    }

    /**
     * Get born date.
     */
    public function getBornDate() : string
    {
        return $this->getParameter('bornDate');
    }

    /**
     * Sets Phone.
     *
     * @return $this.
     */
    public function setPhone(Phone $value)
    {
        return $this->setParameter('phone', $value);
    }

    /**
     * Get Phone.
     */
    public function getPhone() : Phone
    {
        return $this->getParameter('phone');
    }

    /**
     * Sets Address.
     *
     * @return $this.
     */
    public function setAddress(Address $value)
    {
        return $this->setParameter('address', $value);
    }

    /**
     * Get Address.
     */
    public function getAddress() : Address
    {
        return $this->getParameter('address');
    }
}
