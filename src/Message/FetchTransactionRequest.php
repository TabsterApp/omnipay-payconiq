<?php
/**
 * Payconiq Fetch Transaction Request
 */

namespace Omnipay\Payconiq\Message;

class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {

        return [];
    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint().'/transactions/'.$this->getTransactionReference();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
