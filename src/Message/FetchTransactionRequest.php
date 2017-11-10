<?php
/**
 * Payconiq Fetch Transaction Request
 */

namespace Omnipay\Payconiq\Message;

class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('apiKey', 'transactionReference');

        $data = [];
        $data['transactionId'] = $this->getTransactionReference();

        return $data;
    }

    /**
     * @param mixed $data
     * @return FetchTransactionResponse
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest("GET", '/transactions/'.$this->getTransactionReference());

        return $this->response = new FetchTransactionResponse($this, $httpResponse->json());
    }
}
