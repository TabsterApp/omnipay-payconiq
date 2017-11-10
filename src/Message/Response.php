<?php
/**
 * Payconiq Response
 */

namespace Omnipay\Payconiq\Message;

use Guzzle\Http\Message\Response as GuzzleResponse;
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
    /**
     * @var GuzzleResponse
     */
    private $response;

    public function __construct(RequestInterface $request, GuzzleResponse $response)
    {
        parent::__construct($request, $response->json());
        $this->response = $response;
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


    public function getCode()
    {
        return isset($this->data['code']) ? $this->data['code'] : null;
    }

}
