<?php

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Message\AbstractResponse;

/*
 * PagSeguro Refund Response
 *
 * https://dev.pagseguro.uol.com.br/docs/checkout-web-cancelamento-e-estorno#section--a-name-resposta-da-api-a-resposta-da-api
 *
 */

class RefundResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['result']) && $this->data['result'] == 'OK';
    }

    public function getMessage()
    {
        if (!$this->isSuccessful() && isset($this->data['errors'])) {
            return $this->data;
        }

        return null;
    }
}
