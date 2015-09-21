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
        return $this->endpoint . '/mandates/' . $this->getMandateType();
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
