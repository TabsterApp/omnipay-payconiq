<?php
/**
 * Payconiq Fetch Card Request
 */

namespace Omnipay\Payconiq\Message;

class FetchCardRequest extends AbstractRequest
{
    public function getData()
    {

        return [];
    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint().'/customers/'.$this->getCardReference();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
