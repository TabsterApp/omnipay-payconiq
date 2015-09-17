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
    const NOT_VALIDATED = 1;
    const VALIDATED = 10;

    static $CARD_STATUSES = [
        'NOT_VALIDATED' => self::NOT_VALIDATED,
        'VALIDATED' => self::VALIDATED,
    ];

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
     * @return string
     */
    public function getTransactionReference()
    {
        if (!in_array('Location', $this->headers)) {
            throw new InvalidResponseException('No Location header in response.');
        }
        $location = (string)$this->headers['Location'];
        $transactionReference = preg_replace('#^.+?\/transactions\\/([^\/\s]+)#i', '$1', $location);
        if (empty($transactionReference) || strpos('/', $transactionReference) !== false) {
            throw new InvalidResponseException('No transaction id header in response.');
        }
        return $transactionReference;
    }


    /**
     * Get card status
     * @throws InvalidResponseException
     * @return string
     */
    public function getCardStatus()
    {
        $data = $this->getData();
        $cardStatus = $data['bankAccounts']['status'];
        if (in_array($cardStatus, self::$CARD_STATUSES)) {
            throw new InvalidResponseException('Invalid card status in response.');
        }

        return self::$CARD_STATUSES[$cardStatus];
    }

    /**
     * Get a card reference
     * @throws InvalidResponseException
     * @return string
     */
    public function getCardReference()
    {
        if (!in_array('Location', $this->headers)) {
            throw new InvalidResponseException('No Location header in response.');
        }
        $location = (string)$this->headers['Location'];
        $cardReference = preg_replace('#^.+?\/customers\\/([^\/\s]+)#i', '$1', $location);
        if (empty($cardReference) || strpos('/', $cardReference) !== false) {
            throw new InvalidResponseException('No customer id header in response.');
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
