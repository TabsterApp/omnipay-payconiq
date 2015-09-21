<?php
/**
 * Payconiq Create Customer Request
 */

namespace Omnipay\Payconiq\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = [
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'address' => $this->getAddress(),
            'bankAccounts' => [
                [
                    'IBAN' => $this->getAccountNumber(),
                    'name' => 'Tabster',
                ],
            ],
        ];

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/customers';
    }
}
