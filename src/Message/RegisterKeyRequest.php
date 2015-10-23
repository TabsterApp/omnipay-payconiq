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

        $data = [];
        $data['value'] = $this->generatePublicKeyString();

        return $data;
    }


    public function getHttpMethod()
    {
        return 'PUT';
    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint() . '/key';
    }

    private function generatePublicKeyString()
    {
        if (!$this->getKeyPath() || !file_exists($this->getKeyPath() . '.pub')) {
            throw new BadMethodCallException('No public key found for Payconiq at ' . $this->getKeyPath() . '.pub');
        }

        $file = file($this->getKeyPath() . '.pub');
        unset($file[count($file) - 1], $file[0]);

        return implode('', $file);

    }
}
