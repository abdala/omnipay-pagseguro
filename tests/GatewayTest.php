<?php

namespace Omnipay\PagSeguro;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var \Omnipay\PagSeguro\Gateway
     */
    protected $gateway;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $voidOptions;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'email' => 'abdala.cerqueira@gmail.com',
            'token' => 'A13FB5694A124A38A42CFE5624C0DE23',
            'sandbox' => true,
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
        );
    }

    public function testPurchaseSuccess()
    {
        $this->options['amount'] = '10.00';
        
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertInstanceOf('\Omnipay\PagSeguro\Message\PurchaseResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=8CF4BE7DCECEF0F004A6DFA0A8243412', $response->getRedirectUrl());
    }

    /*
    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('ExpressPurchaseFailure.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('This transaction cannot be processed. The amount to be charged is zero.', $response->getMessage());
    }

  

    public function testCompletePurchaseHttpOptions()
    {

        $this->setMockHttpResponse('ExpressPurchaseSuccess.txt');

        $this->getHttpRequest()->query->replace(array(
            'token' => 'GET_TOKEN',
            'PayerID' => 'GET_PAYERID',
        ));

        $response = $this->gateway->completePurchase(array(
            'amount' => '10.00',
            'currency' => 'BYR'
        ))->send();

        $httpRequests = $this->getMockedRequests();
        $httpRequest = $httpRequests[0];
        $queryArguments = $httpRequest->getQuery()->toArray();
        $this->assertSame('GET_TOKEN', $queryArguments['TOKEN']);
        $this->assertSame('GET_PAYERID', $queryArguments['PAYERID']);

    }

    public function testCompletePurchaseCustomOptions()
    {

        $this->setMockHttpResponse('ExpressPurchaseSuccess.txt');

        // Those values should not be used if custom token or payerid are passed
        $this->getHttpRequest()->query->replace(array(
            'token' => 'GET_TOKEN',
            'PayerID' => 'GET_PAYERID',
        ));

        $response = $this->gateway->completePurchase(array(
            'amount' => '10.00',
            'currency' => 'BYR',
            'token' => 'CUSTOM_TOKEN',
            'payerid' => 'CUSTOM_PAYERID'
        ))->send();

        $httpRequests = $this->getMockedRequests();
        $httpRequest = $httpRequests[0];
        $queryArguments = $httpRequest->getQuery()->toArray();
        $this->assertSame('CUSTOM_TOKEN', $queryArguments['TOKEN']);
        $this->assertSame('CUSTOM_PAYERID', $queryArguments['PAYERID']);

    }
*/
}
