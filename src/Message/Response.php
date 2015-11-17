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
    const NOT_VALIDATED = 1;
    const BLOCKED = 2;
    const VALIDATED = 10;

    static $CARD_STATUSES = [
        'NOT_VALIDATED' => self::NOT_VALIDATED,
        'VALIDATED' => self::VALIDATED,
        'BLOCKED' => self::BLOCKED,
    ];

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
     * Get the transaction reference.
     *
     * @return string
     */
    public function getTransactionReference()
    {
        $location = $this->getLocationHeader();
        $transactionReference = preg_replace('#^.+?\/transactions\\/([^\/\s]+)#i', '$1', $location);
        if (empty($transactionReference) || strpos('/', $transactionReference) !== false) {
            throw new InvalidResponseException('No transaction reference header found in response.');
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

        if (!isset($data['bankAccounts'][0]['status']) || in_array(
                $data['bankAccounts'][0]['status'],
                self::$CARD_STATUSES
            )
        ) {
            throw new InvalidResponseException('Invalid card status in response.');
        }

        return self::$CARD_STATUSES[$data['bankAccounts'][0]['status']];
    }

    /**
     * Get a card reference
     * @throws InvalidResponseException
     * @return string
     */
    public function getCardReference()
    {
        $location = $this->getLocationHeader();
        $cardReference = preg_replace('#^.+?\/customers\\/([^\/\s]+)#i', '$1', $location);
        if (empty($cardReference) || strpos('/', $cardReference) !== false) {
            throw new InvalidResponseException('No customer id header in response.');
        }

        return $cardReference;
    }

    private function getLocationHeader()
    {
        if (!$this->response->hasHeader('location')) {
            throw new InvalidResponseException('No "Location" header in response.');
        }

        return (string)$this->response->getHeader('location');
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


    public function getMandateText()
    {
        return $this->data['text'];
    }

    public function getMandateReference()
    {
        return $this->data['reference'];
    }

    public function getDebtorName()
    {
        return $this->data['debtorName'];
    }

    public function getDebtorIBAN()
    {
        return $this->data['debtorIBAN'];
    }

    public function getCreditorAddress()
    {
        return $this->data['creditorAddress'];
    }

    public function getDebtorAddress()
    {
        return $this->data['debtorAddress'];
    }

    public function getSignDate()
    {
        return $this->data['signDate'];
    }

    public function getReason()
    {
        return $this->data['reason'];
    }

    public function getRemainingWeeklyTransactionCountLimit()
    {
        return $this->data['solvency']['remainingWeeklyTransactionCountLimit'];
    }

    public function getRemainingWeeklyTransactionAmountLimit()
    {
        return $this->data['solvency']['remainingWeeklyTransactionAmountLimit'];
    }


    public function getCode()
    {
        return isset($this->data['code']) ? $this->data['code'] : null;
    }

}
