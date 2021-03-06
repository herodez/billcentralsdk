<?php

namespace BillCentralSDK;


use BillCentralSDK\HttpClients\BillCentralGuzzleClient;

class BillRedeemTransaction
{
    /**
     * @var bool transaction in completed.
     */
    private $completed = false;
    /**
     * @var string Bill-Central transaction code.
     */
    private $transactionCode;
    /**
     * @var BillCentralGuzzleClient
     */
    private $client;
    /**
     * @var float transaction point quantity.
     */
    private $pointQuantity;
    /**
     * @var BillCentralResponse Object response that generate the transaction.
     */
    private $response;
    /**
     * @var string bill code of the transaction.
     */
    private $billCode;
    
    /**
     * Create a new Bill-Central transaction.
     *
     * BillTransaction constructor.
     * @param BillCentralResponse $response
     * @param BillCentralGuzzleClient $client
     */
    public function __construct(BillCentralResponse $response, BillCentralGuzzleClient $client)
    {
        $this->response = $response;
        $data = $response->getData();
        $this->transactionCode = $data['transaction_code'];
        $this->pointQuantity = $data['point_quantity'];
        $this->billCode = $data['bill_code'];
        $this->client = $client;
    }
    
    /**
     * Return the transaction code.
     *
     * @return string
     */
    public function getTransactionCode()
    {
        return $this->transactionCode;
    }
    
    /**
     * Return transaction point quantity
     *
     * @return float
     */
    public function getPointQuantity()
    {
        return $this->pointQuantity;
    }
    
    /**
     * Return bill code of the transaction.
     *
     * @return string
     */
    public function getBillCode()
    {
        return $this->billCode;
    }
    
    /**
     * Return if the transaction is completed.
     *
     * @return bool.
     */
    public function isComplete()
    {
        return $this->completed;
    }
    
    /**
     * Finish the transaction to redeem the bill code.
     *
     * @param $data
     * @return BillCentralResponse
     * @throws Exceptions\BillCentralResponseException
     * @throws Exceptions\BillCentralSDKException
     */
    public function complete($data)
    {
        if ($this->completed) {
            throw new \DomainException('Transaction has already been completed.');
        }
        
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Data must be an array.');
        }
        
        $data = array_merge(['transaction_code' => $this->transactionCode],  $data);
        $response = $this->client->makeRequest('POST', Client::COMPETED_BILL_REDEEM_TRANSACTION, $data);
        
        if ($response->getStatus() === BillCentralResponse::STATUS_TRANSACTION_OK) {
            $this->completed = true;
        }
        
        return $response;
    }
    
    /**
     * @return BillCentralResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}