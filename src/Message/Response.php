<?php
/**
 * Payconiq Response
 */

namespace Omnipay\Payconiq\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Payconiq Response
 *
 * This is the response class for all Payconiq requests.
 *
 * @see \Omnipay\Payconiq\Gateway
 */
class Response extends AbstractResponse
{
    private $headers = [];

    public function __construct(RequestInterface $request, $data, $headers)
    {
        parent::__construct($request, $data);
        $this->headers = $headers;
    }


    /**
     * Is the transaction successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return !isset($this->data['code']);
    }

    /**
     * Get the transaction reference.
     *
     * @return string|null
     */
    public function getTransactionReference()
    {


        return null;
    }

    /**
     * Get a customerId
     * @throws InvalidResponseException
     * @return string
     */
    public function getCardReference()
    {
        if (!in_array('Location', $this->headers)) {
            throw new InvalidResponseException('No Location header in response.');
        }
        $location = (string)$this->headers['Location'];
        $cardReference = preg_replace('#^.+?\/customers\\/([a-z0-9]+)#i', '$1', $location);
        if (empty($cardReference) || strpos('/', $cardReference) !== false) {
            throw new InvalidResponseException('No Location header in response.');
        }
        return $cardReference;
    }

    /**
     * Get the card data from the response.
     *
     * @return array|null
     */
    public function getCard()
    {
        if (isset($this->data['card'])) {
            return $this->data['card'];
        }

        return null;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage()
    {
        if (!$this->isSuccessful()) {
            return $this->data['message'];
        }

        return null;
    }
}
