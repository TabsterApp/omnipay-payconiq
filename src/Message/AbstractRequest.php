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
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set the gateway API Key
     *
     * @return AbstractRequest provides a fluent interface.
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getEndpoint()
    {
        return $this->endpoint.'/partners/'.$this->getPartnerId();
    }

    public function getFirstName()
    {
        return $this->getParameter('firstName');
    }

    public function setFirstName($value)
    {
        return $this->setParameter('firstName', $value);
    }

    public function getLastName()
    {
        return $this->getParameter('lastName');
    }

    public function setLastName($value)
    {
        return $this->setParameter('lastName', $value);
    }

    public function getAddress()
    {
        return $this->getParameter('address');
    }

    public function setAddress($value)
    {
        return $this->setParameter('address', $value);
    }

    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
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

    public function send()
    {
        $data = $this->getData();

        return $this->sendData($data);
    }

    /**
     * @param array $data
     * @return Response
     */
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
            [
                'Authorization' => $this->getApiKey(),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',

            ],
            json_encode($data)
        );

        /** @var \Guzzle\Http\Message\Response $httpResponse */
        $httpResponse = $httpRequest->send();


        return $this->response = new Response($this, $httpResponse);
    }


}
