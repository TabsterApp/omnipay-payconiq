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
            'authorization' => '',
        ];
    }

    public function getAuthorization()
    {
        return $this->getParameter('authorization');
    }

    public function setAuthorization($value)
    {
        return $this->setParameter('authorization', $value);
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

}
