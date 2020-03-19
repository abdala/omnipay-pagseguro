<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use function json_decode;
use function json_encode;

class TransactionSearchResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $transactions = [];

        if ($this->isSuccessful()) {
            if ($this->getData()['resultsInThisPage'] === 1) {
                $transactions[] = json_decode(json_encode($this->getData()['transactions']['transaction']), true);
            } elseif ($this->getData()['resultsInThisPage'] > 0) {
                foreach ($this->getData()['transactions']['transaction'] as $transaction) {
                    $transactions[] = json_decode(json_encode($transaction), true);
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
}
