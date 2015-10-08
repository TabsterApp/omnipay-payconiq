<?php
/**
 * Payconiq Fetch Card Request
 */

namespace Omnipay\Payconiq\Message;

class MandatesRequest extends AbstractRequest
{
    public function getData()
    {

        return [];
    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint().'/mandates/'.$this->getCardReference().'/bankAccounts/'.$this->getAccountNumber().'/mandate';
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function sendData($data, $noAuthorization = false, $extraHeaders = [])
    {
        return parent::sendData(
            $data,
            true,
            [
                'Accept-Language' => 'EN',
            ]
        );
    }


}
