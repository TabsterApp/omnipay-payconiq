<?php
/**
 * Payconiq Purchase Request
 */

namespace Omnipay\Payconiq\Message;

class PurchaseRequest extends AbstractRequest
{

    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = [];
        $data['amount'] = $this->getAmountInteger();
        $data['currency'] = strtoupper($this->getCurrency());


        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/customers/' . $this->getCardReference() . '/transactions';
    }
}
