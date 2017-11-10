<?php
use Omnipay\Payconiq\Message\PurchaseRequest;
use Omnipay\Payconiq\Message\PurchaseResponse;
use Omnipay\Tests\TestCase;

/**
 * Date: 10/11/17
 * Time: 09:31
 */
class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'apiKey' => 'mykey',
            'amount' => '12.00',
            'currency' => 'EUR',
            'notifyUrl' => 'http://webhook.test.co'
        ]);
    }

    public function testGetData()
    {
        $this->request->initialize([
            'apiKey' => 'mykey',
            'amount' => '12.00',
            'currency' => 'EUR',
            'notifyUrl' => 'http://webhook.test.co'
        ]);

        $data = $this->request->getData();
        $this->assertSame(1200, $data['amount']);
        $this->assertSame('EUR', $data['currency']);
        $this->assertSame('http://webhook.test.co', $data['callbackUrl']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse("PurchaseSuccess.txt");
        $response = $this->request->send();

        $this->assertInstanceOf(PurchaseResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('testTransactionId', $response->getTransactionReference());
    }
}