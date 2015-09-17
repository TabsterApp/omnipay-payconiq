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
        return parent::getEndpoint() . '/customers/' . $this->getCardReference();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
