<?php
/**
 * Payconiq Purchase Request
 */

namespace Omnipay\Payconiq\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getApplicationFee()
    {
        return $this->getParameter('applicationFee');
    }

    public function getApplicationFeeInteger()
    {
        return (int)round($this->getApplicationFee() * pow(10, $this->getCurrencyDecimalPlaces()));
    }

    public function setApplicationFee($value)
    {
        return $this->setParameter('applicationFee', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = [];
        $data['amount'] = $this->getAmountInteger();
        $data['currency'] = strtolower($this->getCurrency());
        $data['description'] = $this->getDescription();
        $data['metadata'] = $this->getMetadata();
        $data['capture'] = 'true';

        if ($this->getApplicationFee()) {
            $data['application_fee'] = $this->getApplicationFeeInteger();
        }

        if ($this->getCardReference()) {
            $data['customer'] = $this->getCardReference();
        } elseif ($this->getToken()) {
            $data['card'] = $this->getToken();
        } elseif ($this->getCard()) {
            $data['card'] = $this->getCardData();
        } else {
            // one of cardReference, token, or card is required
            $this->validate('card');
        }

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint().'/charges';
    }
}
