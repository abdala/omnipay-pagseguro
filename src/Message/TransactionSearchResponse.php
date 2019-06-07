<?php

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class TransactionSearchResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $transactions = array();

        if ($this->isSuccessful()) {
            if ($this->getData()['resultsInThisPage'] == 1) {
                $transactions[] = $this->xml2array($this->getData()['transactions']['transaction']);
            } else if ($this->getData()['resultsInThisPage'] > 0) {
                foreach ($this->getData()['transactions']['transaction'] as $transaction) {
                    $transactions[] = $this->xml2array($transaction);
                }
            }
        }

        $this->data['transactions'] = $transactions;
    }

    public function getTransactions()
    {
        return $this->data['transactions'];
    }

    public function isSuccessful()
    {
        return isset($this->data['error']) ? false : true;
    }

    protected function xml2array($xml)
    {
        $arr = [];

        foreach ($xml as $element) {
            $tag = $element->getName();
            $e   = get_object_vars($element);

            if (!empty($e)) {
                $arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
                continue;
            }

            $arr[$tag] = trim($element);
        }

        return $arr;
    }
}
