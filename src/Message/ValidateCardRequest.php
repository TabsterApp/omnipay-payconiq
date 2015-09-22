<?php
/**
 * Payconiq Fetch Card Request
 */

namespace Omnipay\Payconiq\Message;

class ValidateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('verificationCode');

        return ['verificationCode' => $this->getVerificationCode()];
    }

    public function getEndpoint()
    {
        return parent::getEndpoint().'/customers/'.
        $this->getCardReference().'/bankAccounts/'.
        $this->getAccountNumber().'/validate';
    }
}
