<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Support\Customer;

use Omnipay\Common\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

class Address
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
    public function __construct(?array $parameters = null)
    {
        $this->initialize($parameters);
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
     * Sets country.
     *
     * @return $this.
     */
    public function setCountry(string $value)
    {
        return $this->setParameter('country', $value);
    }

    /**
     * Get country.
     */
    public function getCountry() : string
    {
        return $this->getParameter('country');
    }

    /**
     * Sets state.
     *
     * @return $this.
     */
    public function setState(string $value)
    {
        return $this->setParameter('state', $value);
    }

    /**
     * Get state.
     */
    public function getState() : string
    {
        return $this->getParameter('state');
    }

    /**
     * Sets city.
     *
     * @return $this.
     */
    public function setCity(string $value)
    {
        return $this->setParameter('city', $value);
    }

    /**
     * Get city.
     */
    public function getCity() : string
    {
        return $this->getParameter('city');
    }

    /**
     * Sets postal code.
     *
     * @return $this.
     */
    public function setPostalCode(string $value)
    {
        return $this->setParameter('postalCode', $value);
    }

    /**
     * Get postal code.
     */
    public function getPostalCode() : string
    {
        return $this->getParameter('postalCode');
    }

    /**
     * Sets postal district.
     *
     * @return $this.
     */
    public function setDistrict(string $value)
    {
        return $this->setParameter('district', $value);
    }

    /**
     * Get postal district.
     */
    public function getDistrict() : string
    {
        return $this->getParameter('district');
    }

    /**
     * Sets street.
     *
     * @return $this.
     */
    public function setStreet(string $value)
    {
        return $this->setParameter('street', $value);
    }

    /**
     * Get street.
     */
    public function getStreet() : string
    {
        return $this->getParameter('street');
    }

    /**
     * Sets number.
     *
     * @return $this.
     */
    public function setNumber(string $value)
    {
        return $this->setParameter('number', $value);
    }

    /**
     * Get number.
     */
    public function getNumber() : string
    {
        return $this->getParameter('number');
    }

    /**
     * Sets complement.
     *
     * @return $this.
     */
    public function setComplement(string $value)
    {
        return $this->setParameter('complement', $value);
    }

    /**
     * Get complement.
     */
    public function getComplement() : string
    {
        return $this->getParameter('complement');
    }
}
