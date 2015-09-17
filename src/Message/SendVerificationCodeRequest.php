<?php
/**
 * Payconiq Fetch Card Request
 */

namespace Omnipay\Payconiq\Message;

class SendVerificationCodeRequest extends AbstractRequest
{
    public function getData()
    {

        return [];
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/customers/' . $this->getCardReference() . '/sendVerificationCode';
    }
}
