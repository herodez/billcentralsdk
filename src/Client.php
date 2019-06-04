<?php

namespace BillCentralSDK;

use BillCentralSDK\HttpClients\BillCentralGuzzleClient;
use InvalidArgumentException;

class Client
{
    /**
     * @const string Production Bill-central API URL.
     */
    const BASE_BC_URL_BILL_REDEEM = '/api-center/redeem/bill/transaction';
    const BASE_BC_URL_USER_AUTHENTICATION = '/api-center/login';
    
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
    const NEW_BILL_REDEEM_TRANSACTION = 'new';
    const COMPETED_BILL_REDEEM_TRANSACTION = 'complete';
    const GENERATE_USER_AUTHENTICATION_TOKEN = 'get-token';
    const LOGIN_USER_AUTHENTICATION = 'login-loyalty-user';
    
    /**
     * Http client instance.
     *
     * @var BillCentralGuzzleClient
     */
    private $client;
    
    /**
     * Base url for Bill Central platform.
     *
     * @var string
     */
    private $baseBcURL;
    
    /**
     * Create a new BillSDK client.
     *
     * BillClient constructor.
     * @param $config
     */
    public function __construct($config)
    {
        if (!is_array($config)) {
            throw new InvalidArgumentException('Config parameters must be an array');
        }
        
        if(!isset($config['base_uri'])){
            throw new InvalidArgumentException('Config need base_uri');
        }
        
        $this->baseBcURL = $config['base_uri'];
        $options = array_merge(['timeout' => self::DEFAULT_REQUEST_TIMEOUT], $config);
        
        $this->client = new BillCentralGuzzleClient($options);
    }
    
    /**
     * Create a new transaction to redeem bill.
     *
     * @param $data
     * @return BillRedeemTransaction
     * @throws Exceptions\BillCentralResponseException
     * @throws Exceptions\BillCentralSDKException
     */
    public function newBillRedeemTransaction($data)
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException('Data parameters must be an array');
        }
        
        $response = $this->client->makeRequest('POST',
            $this->generateURI(self::BASE_BC_URL_BILL_REDEEM, self::NEW_BILL_REDEEM_TRANSACTION), $data);
        return new BillRedeemTransaction($response, $this->client);
    }
    
    /**
     * Get a new user authentication token.
     *
     * @param $data
     * @return BillCentralResponse
     * @throws Exceptions\BillCentralResponseException
     * @throws Exceptions\BillCentralSDKException
     */
    public function getUserAuthenticationToken($data)
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException('Data parameters must be an array');
        }
        
        return $this->client->makeRequest('POST',
            $this->generateURI(self::BASE_BC_URL_USER_AUTHENTICATION, self::GENERATE_USER_AUTHENTICATION_TOKEN), $data);
    }
    
    /**
     * Generate a user authentication url.
     *
     * @param $data
     * @return string
     * @throws Exceptions\BillCentralResponseException
     * @throws Exceptions\BillCentralSDKException
     */
    public function generateUserLoginUrl($data)
    {
        $response = $this->getUserAuthenticationToken($data);
        $path = self::LOGIN_USER_AUTHENTICATION . '/' . $response->getData()['user_token'];
        return $this->generateURI($this->baseBcURL, $path);
    }
    
    /**
     * Generate URI with base and path.
     *
     * @param $base
     * @param $path
     * @return string
     */
    private function generateURI($base, $path)
    {
        return "{$base}/{$path}";
    }
}