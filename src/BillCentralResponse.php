<?php

namespace BillCentralSDK;


class BillCentralResponse
{
    /**
     * @var string http response body.
     */
    private $body;
    /**
     * @var int http response status.
     */
    private $httpStatus;
    /**
     * @var mixed http decode response body.
     */
    private $decodeBody;
    /**
     * @var integer Bill-central status code.
     */
    private $statusBC;
    /**
     * @var array|null Bill-central data.
     */
    private $dataBC;
    
    /**
     * Responses code status.
     */
    const STATUS_TRANSACTION_ERROR = 0;
    const STATUS_TRANSACTION_OK = 1;
    const STATUS_BILL_CODE_NOT_FOUND = 2;
    const STATUS_BILL_CODE_USED = 3;
    const STATUS_BILL_CODE_EXPIRED = 4;
    const STATUS_BILL_PURPOSE_INVALID = 5;
    const STATUS_BILL_COMPANY_INVALID = 6;
    
    /**
     * @var array status codes translation table
     */
    public static $statusTextes = [
        0 => 'TRANSACTION_ERROR',
        1 => 'TRANSACTION_OK',
        2 => 'BILL_CODE_NOT_FOUND',
        3 => 'BILL_CODE_USED',
        4 => 'BILL_CoDE_EXPIRED',
        5 => 'BILL_PURPOSE_INVALID',
        6 => 'BILL_COMPANY_INVALID'
    ];
    
    public function __construct($httpStatus, $httpContent)
    {
        $this->body = $httpContent;
        $this->httpStatus = $httpStatus;
        $this->decodeBody = json_decode($httpContent, true);
        $this->statusBC = $this->get('status');
        $this->dataBC = $this->get('data');
    }
    
    /**
     * @return mixed get raw http response body.
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * @return mixed get http response code.
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatus;
    }
    
    /**
     * @return mixed get http response decode body.
     */
    public function getDecodeBody()
    {
        return $this->decodeBody;
    }
    
    /**
     * @return mixed get the data decode of the Bill-central.
     */
    public function getData()
    {
        return $this->dataBC;
    }
    
    /**
     * @return mixed get the status of the Bill-central.
     */
    public function getStatus()
    {
        return $this->statusBC;
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
        if (isset($this->decodeBody[$key])) {
            return $this->decodeBody[$key];
        }
        return $default;
    }
}