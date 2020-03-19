<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Support\Customer;

use Omnipay\Common\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

class Phone
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
     * Sets area code.
     *
     * @return $this.
     */
    public function setAreaCode(string $value)
    {
        return $this->setParameter('areaCode', $value);
    }

    /**
     * Get area code.
     */
    public function getAreaCode() : string
    {
        return $this->getParameter('areaCode');
    }

    /**
     * Sets phone.
     *
     * @return $this.
     */
    public function setPhone(string $value)
    {
        return $this->setParameter('phone', $value);
    }

    /**
     * Get phone.
     */
    public function getPhone() : string
    {
        return $this->getParameter('phone');
    }
}
