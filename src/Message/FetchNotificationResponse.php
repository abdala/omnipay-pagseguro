<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Message\AbstractResponse;

/*
 * PagSeguro Fetch Notification Request
 *
 * https://dev.pagseguro.uol.com.br/docs/checkout-web-notificacoes
 *
 */

class FetchNotificationResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['code']);
    }
}
