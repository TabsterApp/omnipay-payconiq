<?php
/**
 * Payconiq Purchase Request
 */

namespace Omnipay\Payconiq\Message;

use Omnipay\Common\Exception\BadMethodCallException;

class RegisterKeyRequest extends AbstractRequest
{

    public function getData()
    {
        $publicKey = '';
        if ($this->getPublicKey()) {
            $publicKey = $this->getPublicKey();
        } else {
            if (!$this->getKeyPath() || !file_exists($this->getKeyPath().'.pub')) {
                throw new BadMethodCallException('No public key found for Payconiq at '.$this->getKeyPath().'.pub');
            }
            $publicKey = file_get_contents($this->getKeyPath().'.pub');
        }

        $data = [];
        $data['value'] = $publicKey;


        return $data;
    }


    public function getHttpMethod()
    {
        return 'PUT';
    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint().'/key';
    }
}
