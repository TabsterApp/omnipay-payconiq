<?php
/**
 * Date: 08/10/15
 * Time: 10:50
 */

namespace Omnipay\Payconiq\Message;


class CancelMandatesRequest extends AbstractRequest
{
    public function getData()
    {
        return [];
    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint().'/customers/'.$this->getCardReference(
        ).'/bankAccounts/'.$this->getAccountNumber().'/mandate/cancel';
    }

    public function getHttpMethod()
    {
        return 'POST';
    }
}