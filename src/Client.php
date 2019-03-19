<?php

namespace BillCentralSDK;

use BillCentralSDK\HttpClients\BillCentralGuzzleClient;

class Client
{
    /**
     * @const string Production Bill-central API URL.
     */
    const BASE_BC_URL = 'http://billcentral.test/api';
    
    /**
     * @const string Default Bill-central API version for requests.
     */
    const DEFAULT_BC_VERSION = 'V1';
    
    /**
     * @const int The timeout in seconds for a normal request.
     */
    const DEFAULT_REQUEST_TIMEOUT = 60;
    
    /**
     * Endpoints constants
     */
    const NEW_TRANSACTION = 'validate';
    const COMPETED_TRANSACTION = 'redeem';
    
    /**
     * Http client instance.
     *
     * @var BillCentralGuzzleClient
     */
    private $client;
    
    /**
     * Create a new BillSDK client.
     *
     * BillClient constructor.
     * @param $config
     */
    public function __construct($config)
    {
        if (!is_array($config)) {
            throw new \InvalidArgumentException('Config parameters must be an array');
        }
        
        $options = array_merge([
            'base_uri' => self::BASE_BC_URL . '/' . self::DEFAULT_BC_VERSION . '/',
            'timeout' => self::DEFAULT_REQUEST_TIMEOUT
        ], $config);
        
        $this->client = new BillCentralGuzzleClient($options);
    }
    
    /**
     * Create a new transaction to redeem bill.
     *
     * @param $data
     * @return BillTransaction
     * @throws Exceptions\BillCentralResponseException
     * @throws Exceptions\BillCentralSDKException
     */
    public function newTransaction($data)
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Data parameters must be an array');
        }
        
        if (!isset($data['bill'])) {
            throw new \InvalidArgumentException('Data bill parameters must be exist');
        }
        
        if (!isset($data['company_id'])) {
            throw new \InvalidArgumentException('Data company_id parameters must be exist');
        }
        
        $response =$this->client->makeRequest('POST', self::NEW_TRANSACTION, $data);
        return new BillTransaction($response, $this->client);
    }
}