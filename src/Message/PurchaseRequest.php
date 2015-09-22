<?php
/**
 * Payconiq Purchase Request
 */

namespace Omnipay\Payconiq\Message;

use Omnipay\Common\Exception\BadMethodCallException;

class PurchaseRequest extends AbstractRequest
{

    public function getData()
    {
        $this->validate('amount', 'currency', 'cardReference', 'accountNumber');


        $data = [
            'originId' => $this->getCardReference(),
            'originIBAN' => $this->getAccountNumber(),
            'targetIBAN' => 'DE21200500000123456000',
            'amount' => $this->getAmountInteger(),
            'currency' => strtoupper($this->getCurrency()),
        ];

        $data['signature'] = $this->generateSignature($data);

        return $data;
    }

    private function generateSignature(array $data)
    {
        //"<Base64 Encode(SHA256 Encrypt(concat(partnerId, customerId, optional originIban, amount, currency), private key)>"
        if (!$this->getKeyPath() || !file_exists($this->getKeyPath())) {
            throw new BadMethodCallException('No private key found for Payconiq at '.$this->getKeyPath());
        }
        $privateKey = file_get_contents($this->getKeyPath());
        $hashString = $this->getPartnerId().$data['originId'].
            $data['originIBAN'].$data['amount'].$data['currency'];

        return base64_encode(hash_hmac('sha256', $hashString, $privateKey));

    }

    public function getEndpoint()
    {
        return parent::getEndpoint().'/customers/'.$this->getCardReference().'/transactions';
    }
}
