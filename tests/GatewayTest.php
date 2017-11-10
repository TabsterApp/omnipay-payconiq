<?php
use Omnipay\Payconiq\Message\FetchTransactionRequest;
use Omnipay\Payconiq\Message\PurchaseRequest;
use Omnipay\Tests\GatewayTestCase;

/**
 * Date: 10/11/17
 * Time: 10:59
 */
class GatewayTest extends GatewayTestCase
{
    /**
     * @var \Omnipay\Payconiq\Gateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new \Omnipay\Payconiq\Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(['amount' => "10.00"]);

        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertSame("10.00", $request->getAmount());
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction(['transactionReference' => 'testReference']);

        $this->assertInstanceOf(FetchTransactionRequest::class, $request);

        $data = $request->getData();
        $this->assertSame('testReference', $data['transactionId']);
    }
}