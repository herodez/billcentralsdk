<?php

namespace BillCentralSDK\Exceptions;


use BillCentralSDK\BillCentralResponse;

class BillCentralResponseException extends BillCentralSDKException
{
    /**
     * @var BillCentralResponse The response that threw the exception.
     */
    private $response;
    
    /**
     * @var array Decoded response.
     */
    private $responseData;
    
    /**
     * Creates a BillCentralResponseException.
     *
     * @param BillCentralResponse $response The response that threw the exception.
     * @param BillCentralSDKException $previousException The more detailed exception.
     */
    public function __construct(BillCentralResponse $response, BillCentralSDKException $previousException = null)
    {
        $this->response = $response;
        $this->responseData = $response->getDecodeBody();
        $errorMessage = $this->get('message', 'Unknown error from BC.');
        $errorCode = $this->get('code', BillCentralResponse::STATUS_UNKNOWN_CODE);
        parent::__construct($errorMessage, $errorCode, $previousException);
    }
    
    
    /**
     * A factory for creating the appropriate exception based on the response from Bill-Central.
     *
     * @param BillCentralResponse $response The response that threw the exception.
     *
     * @return BillCentralResponseException
     */
    public static function create(BillCentralResponse $response)
    {
        $code = $response->getStatus();
        $data = $response->getDecodeBody();
        $message = isset($data['error']['message']) ? $data['error']['message'] : 'Unknown error from BC.';
        
        switch ($code) {
            case BillCentralResponse::STATUS_BILL_CODE_NOT_FOUND:
                return new static($response, new BillCentralCodeNotFoundException($message, $code));
            case BillCentralResponse::STATUS_BILL_CODE_USED:
                return new static($response, new BillCentralCodeUsedException($message, $code));
            case BillCentralResponse::STATUS_BILL_CODE_EXPIRED:
                return new static($response, new BillCentralCodeExpiredException($message, $code));
            case BillCentralResponse::STATUS_BILL_PURPOSE_INVALID:
                return new static($response, new BillCentralPurposeInvalidException($message, $code));
            case BillCentralResponse::STATUS_BILL_COMPANY_INVALID:
                return new static($response, new BillCentralCompanyInvalidException($message, $code));
            case BillCentralResponse::STATUS_TRANSACTION_ERROR:
                return new static($response, new BillCentralTransactionError($message, $code));
            default:
                return new static($response,
                    new BillCentralOtherException($message, BillCentralResponse::STATUS_UNKNOWN_CODE));
        }
    }
    
    /**
     * Returns the response entity used to create the exception.
     *
     * @return BillCentralResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * Returns the raw response used to create the exception.
     *
     * @return string
     */
    public function getRawResponse()
    {
        return $this->response->getBody();
    }
    
    /**
     * Returns the decoded response used to create the exception.
     *
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }
    
    /**
     * Returns the HTTP status code
     *
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->response->getHttpStatusCode();
    }
    
    /**
     * Checks isset and returns that or a default value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    private function get($key, $default = null)
    {
        if (isset($this->responseData['error'][$key])) {
            return $this->responseData['error'][$key];
        }
        return $default;
    }
}