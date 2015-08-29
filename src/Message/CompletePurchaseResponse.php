<?php

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * PagSeguro Response
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['error']) ? false : true;
    }
}
