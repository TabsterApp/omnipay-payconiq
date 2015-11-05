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
        return $this->getPartnerEndpoint().'/customers/'.
        $this->getCardReference().'/bankAccounts/'.
        $this->getAccountNumber().'/mandate';
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function sendData($data, $noAuthorization = false, $extraHeaders = [])
    {
        return parent::sendData(
            $data,
            false,
            [
                'Accept-Language' => $this->getLanguage(),
            ]
        );
    }
}
