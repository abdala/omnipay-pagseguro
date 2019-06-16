<?php

namespace Omnipay\PagSeguro\Message;

use DateTime;
use Omnipay\Common\Exception\InvalidRequestException;

class TransactionSearchRequest extends AbstractRequest
{
    protected $resource = "transactions";
    protected $abandonedResource = "transactions/abandoned";

    /**
     * @return boolean
     */
    public function getAbandoned()
    {
        return $this->getParameter('abandoned');
    }

    /**
     * @param boolean $date
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setAbandoned($value)
    {
        return $this->setParameter('abandoned', $value);
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate()
    {
        return $this->getParameter('startDate');
    }

    /**
     * @param DateTime|string $date
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setStartDate($date)
    {
        if (! $date instanceof DateTime) {
            $date = new DateTime($date);
        }

        return $this->setParameter('startDate', $date);
    }

    /**
     * @return DateTime|null
     */
    public function getEndDate()
    {
        return $this->getParameter('endDate');
    }

    /**
     * @param DateTime|string $date
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setEndDate($date)
    {
        if (! $date instanceof DateTime) {
            $date = new DateTime($date);
        }

        return $this->setParameter('endDate', $date);
    }

    /**
     * @return null
     */
    public function getPage()
    {
        return $this->getParameter('page');
    }

    /**
     * @param string $page
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setPage($page)
    {
        return $this->setParameter('page', $page);
    }

    /**
     * @return null
     */
    public function getMaxPageResults()
    {
        return $this->getParameter('maxPageResults');
    }

    /**
     * @param int $maxPageResults
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setMaxPageResults($maxPageResults)
    {
        return $this->setParameter('maxPageResults', $maxPageResults);
    }

    protected function createResponse($data)
    {
        return $this->response = new TransactionSearchResponse($this, $data);
    }

    public function getData()
    {
        $this->validate('startDate', 'endDate');

        $now = new DateTime('now');
        $startDate = $this->getStartDate();
        $finalDate = $this->getEndDate();

        //Start Date and End Date less than today
        if ($startDate >= $now) {
            throw new InvalidRequestException("The initial date must be less than today");
        }
        if ($finalDate >= $now) {
            throw new InvalidRequestException("The final date must be less than today");
        }

        //The interval between the initial date and final date must be less than 30 days
        if ($startDate->diff($finalDate)->days > 30) {
            throw new InvalidRequestException("The interval between the initial date and final date must be less than 30 days");
        }

        $data = [
            'initialDate' => $startDate->format('Y-m-d\TH:i'),
            'finalDate' => $finalDate->format('Y-m-d\TH:i'),
            'page' => $this->getPage(),
            'maxPageResults' => $this->getMaxPageResults(),
        ];

        return array_merge(parent::getData(), $data);
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function sendData($data)
    {
        $url = sprintf('%s/%s?%s',
            $this->getEndpoint(),
            $this->getResource(),
            http_build_query($data, '', '&'));

        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $url);
        $xml = simplexml_load_string($httpResponse->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return $this->createResponse($this->xml2array($xml));
    }

    public function getResource()
    {
        if ($this->getAbandoned()) {
            return $this->abandonedResource;
        } else {
            return $this->resource;
        }
    }
}
