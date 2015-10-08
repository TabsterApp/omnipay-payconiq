<?php
/**
 * Date: 08/10/15
 * Time: 13:46
 */

namespace Omnipay\Payconiq\Message;


class MandatesTextRequest extends AbstractRequest
{
    public function getData()
    {

        return [];
    }

    public function getEndpoint()
    {
        return $this->getEnvironmentEndPoint().'/mandates/'.$this->getMandateType();
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