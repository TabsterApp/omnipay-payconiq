<?php
/**
 * Payconiq Create Customer Request
 */

namespace Omnipay\Payconiq\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = $this->getCardData();


        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint().'/customers';
    }
}
