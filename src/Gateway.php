<?php
/**
 * Payconiq Gateway
 */

namespace Omnipay\Payconiq;

use Omnipay\Common\AbstractGateway;


class Gateway extends AbstractGateway
{

    public function getName()
    {
        return 'Payconiq';
    }

    public function getDefaultParameters()
    {
        return [
            'partnerId' => '',
            'apiKey' => '',
        ];
    }

    public function getPartnerId()
    {
        return $this->getParameter('partnerId');
    }

    public function setPartnerId($value)
    {
        return $this->setParameter('partnerId', $value);
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Payconiq\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Payconiq\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Payconiq\Message\CreateCardRequest
     */
    public function createCard(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Payconiq\Message\CreateCardRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Payconiq\Message\FetchCardRequest
     */
    public function fetchCard(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Payconiq\Message\FetchCardRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Payconiq\Message\SendVerificationCodeRequest
     */
    public function sendVerificationCode(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Payconiq\Message\SendVerificationCodeRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Payconiq\Message\MandatesRequest
     */
    public function mandates(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Payconiq\Message\MandatesRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Payconiq\Message\ValidateCardRequest
     */
    public function validateCard(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Payconiq\Message\ValidateCardRequest', $parameters);
    }

}
