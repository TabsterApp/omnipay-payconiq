<?php
/**
 * Payconiq Purchase Request
 */

namespace Omnipay\Payconiq\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'currency', 'notifyUrl');

        $data = [
            'amount' => $this->getAmountInteger(),
            'currency' => strtoupper($this->getCurrency()),
            'callbackUrl' => $this->getNotifyUrl(),
        ];

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest("POST", '/transactions', $data);

        return $this->response = new PurchaseResponse($this, $httpResponse->json());
    }
}
