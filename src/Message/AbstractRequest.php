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
    protected $endpoint = 'https://dev.payconiq.com/v1';

    public function setPartnerId($value)
    {
        return $this->setParameter('partnerId', $value);
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

    public function getFirstName()
    {
        return $this->getParameter('firstName');
    }

    public function setFirstName($value)
    {
        return $this->setParameter('firstName', $value);
    }

    public function getMandateType()
    {
        return $this->getParameter('mandateType');
    }

    public function setMandateType($value)
    {
        return $this->setParameter('mandateType', $value);
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

    public function getVerificationCode()
    {
        return $this->getParameter('verificationCode');
    }

    public function setVerificationCode($value)
    {
        return $this->setParameter('verificationCode', $value);
    }

    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    public function send()
    {
        $data = $this->getData();

        return $this->sendData($data);
    }


    /**
     * Gets the test mode of the request from the gateway.
     *
     * @return boolean
     */
    public function getTestMode()
    {
        if ('https://dev.payconiq.com/v1' == $this->endpoint) {
            return true;
        }

        return false;
    }


    /**
     * @param array $data
     * @return Response
     */
    public function sendData($data, $noAuthorization = false, $extraHeaders = [])
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
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        if (!$noAuthorization) {
            $headers['Authorization'] = $this->getApiKey();
        }
        if (!empty($extraHeaders)) {
            $headers += $extraHeaders;
        }
        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            !empty($data) ? json_encode($data) : null
        );
        if ($this->getTestMode()) {
            $httpRequest->getCurlOptions()->set(CURLOPT_SSL_VERIFYHOST, false);
            $httpRequest->getCurlOptions()->set(CURLOPT_SSL_VERIFYPEER, false);
        }

        /** @var \Guzzle\Http\Message\Response $httpResponse */
        $httpResponse = $httpRequest->send();

        return $this->response = new Response($this, $httpResponse);
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

    public function getEndpoint()
    {
        return $this->endpoint.'/partners/'.$this->getPartnerId();
    }

    public function getPartnerId()
    {
        return $this->getParameter('partnerId');
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


}
