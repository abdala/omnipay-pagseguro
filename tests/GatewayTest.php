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
            'email' => PAGSEGURO_API_EMAIL,
            'token' => PAGSEGURO_API_KEY,
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

    public function testCompletePurchaseHttpOptions()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        
        $this->options['notificationCode'] = '9E884542-81B3-4419-9A75-BCC6FB495EF1';
        
        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertInstanceOf('\Omnipay\PagSeguro\Message\CompletePurchaseResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('9E884542-81B3-4419-9A75-BCC6FB495EF1', $response->getData()['code']);
    }
}
