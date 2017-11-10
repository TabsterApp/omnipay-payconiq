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
        return $this->getPartnerEndpoint().
        '/customers/'.$this->getCardReference().'/bankAccounts/'.
        $this->getAccountNumber().'/sendVerificationCode';
    }
}
