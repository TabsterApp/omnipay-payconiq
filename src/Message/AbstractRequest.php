<?php
/**
 * Payconiq Abstract Request
 */

namespace Omnipay\Payconiq\Message;

use Guzzle\Common\Event;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Live or Test Endpoint URL
     *
     * @var string URL
     */
    protected $endpoint = 'http://172.17.15.88:8080/payconiq/v1';

    public function getPartnerId()
    {
        return $this->getParameter('partnerId');
    }

    public function setPartnerId($value)
    {
        return $this->setParameter('partnerId', $value);
    }

    /**
     * Get the gateway API Key
     *
     * @return string
     */
    public function getAuthorization()
    {
        return $this->getParameter('authorization');
    }

    /**
     * Set the gateway API Key
     *
     * @return AbstractRequest provides a fluent interface.
     */
    public function setAuthorization($value)
    {
        return $this->setParameter('authorization', $value);
    }

    public function getEndpoint()
    {
        return $this->endpoint.'/partners/'.$this->getPartnerId();
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function (Event $event) {
                /**
                 * @var \Guzzle\Http\Message\Response $response
                 */
                $response = $event['response'];
                if ($response->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
            $data
        );
        $httpResponse = $httpRequest
            ->setHeader('Authorization', $this->getAuthorization())
            ->send();

        return $this->response = new Response($this, $httpResponse->json());
    }


    /**
     * Get the card data.
     *
     * @return array
     */
    protected function getCardData()
    {
        $data = [];
        $data['bankAccounts'] = [
            'IBAN' => $this->getCard()->getNumber(),
            'name' => 'Tabster',
        ];
        $data['firstName'] = $this->getCard()->getFirstName();
        $data['lastName'] = $this->getCard()->getLastName();
        $data['address'] = [
            'street' => $this->getCard()->getAddress1(),
            'no' => $this->getCard()->getAddress2(),
            'postalCode' => $this->getCard()->getPostcode(),
            'city' => $this->getCard()->getCity(),
            'country' => $this->getCard()->getCountry(),
        ];

        return $data;
    }
}
