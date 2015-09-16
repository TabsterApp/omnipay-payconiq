<?php
/**
 * Payconiq Create Credit Card Request
 */

namespace Omnipay\Payconiq\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = [];


        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint().'/customers';
    }
}
