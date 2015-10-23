<?php
/**
 * Date: 08/10/15
 * Time: 10:46
 */

namespace Omnipay\Payconiq\Message;


class ConfirmMandatesRequest extends AbstractRequest
{
    public function getData()
    {
        return [];
    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint().'/customers/'.$this->getCardReference(
        ).'/bankAccounts/'.$this->getAccountNumber().'/mandate';
    }

    public function getHttpMethod()
    {
        return 'POST';
    }
}