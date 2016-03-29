<?php

namespace Omnipay\PagSeguro\Support\Customer;

use Omnipay\Common\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

class Address
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
     */
    public function __construct($parameters = null)
    {
        $this->initialize($parameters);

        $this->getCountry('BRA');
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
     * Sets country.
     *
     * @param string $value
     * @return $this.
     */
    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * Sets state.
     *
     * @param string $value
     * @return $this.
     */
    public function setState($value)
    {
        return $this->setParameter('state', $value);
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function getState()
    {
        return $this->getParameter('state');
    }

    /**
     * Sets city.
     *
     * @param string $value
     * @return $this.
     */
    public function setCity($value)
    {
        return $this->setParameter('city', $value);
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->getParameter('city');
    }

    /**
     * Sets postal code.
     *
     * @param string $value
     * @return $this.
     */
    public function setPostalCode($value)
    {
        return $this->setParameter('postalCode', $value);
    }

    /**
     * Get postal code.
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->getParameter('postalCode');
    }


    /**
     * Sets postal district.
     *
     * @param string $value
     * @return $this.
     */
    public function setDistrict($value)
    {
        return $this->setParameter('district', $value);
    }

    /**
     * Get postal district.
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->getParameter('district');
    }

    /**
     * Sets street.
     *
     * @param string $value
     * @return $this.
     */
    public function setStreet($value)
    {
        return $this->setParameter('street', $value);
    }

    /**
     * Get street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->getParameter('street');
    }

    /**
     * Sets number.
     *
     * @param string $value
     * @return $this.
     */
    public function setNumber($value)
    {
        return $this->setParameter('number', $value);
    }

    /**
     * Get number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->getParameter('number');
    }

    /**
     * Sets complement.
     *
     * @param string $value
     * @return $this.
     */
    public function setComplement($value)
    {
        return $this->setParameter('complement', $value);
    }

    /**
     * Get complement.
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->getParameter('complement');
    }
}