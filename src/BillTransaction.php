<?php

namespace BillCentralSDK;


use BillCentralSDK\HttpClients\BillCentralGuzzleClient;

class BillTransaction
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
     * Create a new Bill-Central transaction.
     *
     * BillTransaction constructor.
     * @param BillCentralResponse $response
     * @param BillCentralGuzzleClient $client
     */
    public function __construct(BillCentralResponse $response, BillCentralGuzzleClient $client)
    {
        $this->transactionCode = $response->getData()['transaction_code'];
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
     * Return if the transaction is completed.
     *
     * @return bool.
     */
    public function isComplete()
    {
        return $this->completed;
    }
    
    /**
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
        
        $data = array_merge(['transaction_code' => $this->transactionCode], ['user' => $data]);
        $response = $this->client->makeRequest('POST', Client::COMPETED_TRANSACTION, $data);
        
        if ($response->getStatus() === BillCentralResponse::STATUS_TRANSACTION_OK) {
            $this->completed = true;
        }
        
        return $response;
    }
}