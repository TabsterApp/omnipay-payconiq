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
        $string = $this->getPartnerId().$data['originId'].$data['amount'].$data['currency'];
        $binary_signature = '';
        openssl_sign($string, $binary_signature, $privateKey, 'SHA256');

        return base64_encode($binary_signature);

    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint().'/transactions';
    }
}
