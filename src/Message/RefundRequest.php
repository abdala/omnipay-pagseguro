<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use function array_merge;
use function http_build_query;
use function simplexml_load_string;
use function sprintf;
use const LIBXML_NOCDATA;
/**
 * PagSeguro Refund Request
 *
 * https://dev.pagseguro.uol.com.br/docs/checkout-web-cancelamento-e-estorno
 *
 * <code>
 *   // Do a refund transaction on the gateway
 *   $transaction = $gateway->refund(array(
 *       'amount'                   => '10.00',
 *       'transactionReference'     => $transactionCode,
 *   ));
 *
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *   }
 * </code>
 */

class RefundRequest extends AbstractRequest
{
    protected $resource = 'transactions/refunds';

    public function getData()
    {
        $this->validate('transactionReference');

        $data = [
            'transactionCode' => $this->getTransactionReference(),
        ];

        if ($this->getAmount()) {
            $data['refundValue'] = $this->getAmount();
        }

        return array_merge(parent::getData(), $data);
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

    protected function createResponse($data)
    {
        return $this->response = new RefundResponse($this, $data);
    }
}
