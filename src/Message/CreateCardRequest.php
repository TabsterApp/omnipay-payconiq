<?php
/**
 * Payconiq Create Customer Request
 */

namespace Omnipay\Payconiq\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('firstName', 'lastName', 'address', 'accountNumber', 'phoneNumber');
        $data = [
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'address' => $this->getAddress(),
            'phoneNumber' => $this->getPhoneNumber(),
            'bankAccounts' => [
                [
                    'IBAN' => $this->getAccountNumber(),
                    'name' => 'Payconiq',
                ],
            ],
        ];

        return $data;
    }

    public function getEndpoint()
    {
        return $this->getPartnerEndpoint() . '/customers';
    }
}
