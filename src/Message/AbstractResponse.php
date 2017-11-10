<?php
/**
 * Date: 10/11/17
 * Time: 11:23
 */

namespace Omnipay\Payconiq\Message;


class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        return !$this->isRedirect() && !isset($this->data['error']);
    }

    public function getMessage()
    {
        if (isset($this->data['error'])) {
            return $this->data['error']['message'];
        }
    }
}