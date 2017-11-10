<?php
use Omnipay\Payconiq\Message\FetchTransactionRequest;
use Omnipay\Payconiq\Message\FetchTransactionResponse;
use Omnipay\Tests\TestCase;

/**
 * Date: 10/11/17
 * Time: 11:17
 */
class FetchTransactionRequestTest extends TestCase
{
    /**
     * @var FetchTransactionRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'apiKey' => 'testKey',
            'transactionReference' => 'testTransactionReference123243'
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('testTransactionReference123243', $data['transactionId']);
        $this->assertCount(1, $data);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('FetchTransactionSuccess.txt');
        /** @var FetchTransactionResponse $response */
        $response = $this->request->send();

        $this->assertInstanceOf(FetchTransactionResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame("SUCCEEDED", $response->getStatus());
        $this->assertSame('testTransactionReference123243', $response->getTransactionReference());
    }
}