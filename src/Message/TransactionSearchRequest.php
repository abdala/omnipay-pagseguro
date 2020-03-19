<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use DateTime;
use Omnipay\Common\Exception\InvalidRequestException;
use function array_merge;
use function http_build_query;
use function simplexml_load_string;
use function sprintf;
use const LIBXML_NOCDATA;

class TransactionSearchRequest extends AbstractRequest
{
    protected $resource          = 'transactions';
    protected $abandonedResource = 'transactions/abandoned';

    public function getAbandoned() : bool
    {
        return $this->getParameter('abandoned');
    }

    public function setAbandoned($value) : \Omnipay\Common\Message\AbstractRequest
    {
        return $this->setParameter('abandoned', $value);
    }

    public function getStartDate() : ?DateTime
    {
        return $this->getParameter('startDate');
    }

    /**
     * @param DateTime|string $date
     */
    public function setStartDate($date) : \Omnipay\Common\Message\AbstractRequest
    {
        if (! $date instanceof DateTime) {
            $date = new DateTime($date);
        }

        return $this->setParameter('startDate', $date);
    }

    public function getEndDate() : ?DateTime
    {
        return $this->getParameter('endDate');
    }

    /**
     * @param DateTime|string $date
     */
    public function setEndDate($date) : \Omnipay\Common\Message\AbstractRequest
    {
        if (! $date instanceof DateTime) {
            $date = new DateTime($date);
        }

        return $this->setParameter('endDate', $date);
    }

    public function getPage()
    {
        return $this->getParameter('page');
    }

    public function setPage(string $page) : \Omnipay\Common\Message\AbstractRequest
    {
        return $this->setParameter('page', $page);
    }

    public function getMaxPageResults()
    {
        return $this->getParameter('maxPageResults');
    }

    public function setMaxPageResults(int $maxPageResults) : \Omnipay\Common\Message\AbstractRequest
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

        $now       = new DateTime('now');
        $startDate = $this->getStartDate();
        $finalDate = $this->getEndDate();

        //Start Date and End Date less than today
        if ($startDate >= $now) {
            throw new InvalidRequestException('The initial date must be less than today');
        }

        if ($finalDate >= $now) {
            throw new InvalidRequestException('The final date must be less than today');
        }

        //The interval between the initial date and final date must be less than 30 days
        if ($startDate->diff($finalDate)->days > 30) {
            throw new InvalidRequestException('The interval between the initial date and final date must be less than 30 days');
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
        $url = sprintf(
            '%s/%s?%s',
            $this->getEndpoint(),
            $this->getResource(),
            http_build_query($data, '', '&')
        );

        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $url);
        $xml          = simplexml_load_string($httpResponse->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);

        return $this->createResponse($this->xml2array($xml));
    }

    public function getResource()
    {
        if ($this->getAbandoned()) {
            return $this->abandonedResource;
        }

        return $this->resource;
    }
}
