<?php
/**
 * Payconiq Abstract Request
 */

namespace Omnipay\Payconiq\Message;

use Guzzle\Common\Event;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://api.payconiq.com/v2';

    /**
     * Set the gateway API Key
     *
     * @return \Omnipay\Common\Message\AbstractRequest provides a fluent interface.
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
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

    public function send()
    {
        $data = $this->getData();

        return $this->sendData($data);
    }

    public function getEnvironmentEndPoint()
    {
        if ($this->getTestMode()) {
            $this->endpoint = 'https://dev.payconiq.com/v2';
        }

        return $this->endpoint;
    }

    public function getEndPoint()
    {
        return $this->getEnvironmentEndPoint();
    }

    protected function sendRequest($method, $endpoint, $data = null)
    {
        $this->httpClient->getEventDispatcher()->addListener('request.error', function (Event $event) {
            /**
             * @var \Guzzle\Http\Message\Response $response
             */
            $response = $event['response'];

            if ($response->isError()) {
                $event->stopPropagation();
            }
        });

        $httpRequest = $this->httpClient->createRequest(
            $method,
            $this->getEndPoint() . $endpoint,
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $this->getApiKey(),
            ],
            $data
        );

        return $httpRequest->send();
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
}
