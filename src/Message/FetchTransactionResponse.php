<?php
/**
 * Date: 10/11/17
 * Time: 10:29
 */

namespace Omnipay\Payconiq\Message;




class FetchTransactionResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return parent::isSuccessful();
    }

    /**
     * @return mixed
     */
    public function getTransactionReference()
    {
        if (isset($this->data['_id'])) {
            return $this->data['_id'];
        }
    }

    public function getStatus()
    {
        if(isset($this->data['status'])){
            return $this->data['status'];
        }
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        if (isset($this->data['amount'])) {
            return $this->data['amount'];
        }
    }
}