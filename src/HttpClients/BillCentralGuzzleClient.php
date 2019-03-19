<?php

namespace BillCentralSDK\HttpClients;

use BillCentralSDK\BillCentralResponse;
use BillCentralSDK\Exceptions\BillCentralResponseException;
use BillCentralSDK\Exceptions\BillCentralSDKException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BillCentralGuzzleClient
{
    /**
     * @var Client the client to execute http request
     */
    private $client;
    /**
     * @var array base data request format.
     */
    private $baseRequest;
    
    /**
     * Create a BillCentral http client base in GuzzleHttp/Client.
     *
     * BillCentralGuzzleClient constructor.
     * @param $options
     */
    public function __construct($options)
    {
        $this->client = new Client([
            'base_uri' => $options['base_uri'],
            'timeout' => $options['timeout']
        ]);
        
        $this->baseRequest = [
            'json' => [
                'api_key' => $options['api_key'],
                'data' => []
            ]
        ];
    }
    
    /**
     * Prepared request data to send.
     *
     * @param $data
     * @return array
     */
    private function preparedRequest($data)
    {
        $this->baseRequest['json']['data'] = $data;
        return $this->baseRequest;
    }
    
    /**
     * Make a http request.
     *
     * @param $method
     * @param $path
     * @param $data
     * @return mixed
     * @throws BillCentralResponseException
     * @throws BillCentralSDKException
     */
    public function makeRequest($method, $path, $data)
    {
        try {
            $response = $this->client->request($method, $path, $this->preparedRequest($data));
        } catch (GuzzleException $exception) {
            throw new BillCentralSDKException($exception->getMessage(), $exception->getCode());
        }
        
        $response = new BillCentralResponse($response->getStatusCode(), $response->getBody());
        
        if ($response->getStatus() !== BillCentralResponse::STATUS_TRANSACTION_OK) {
            throw BillCentralResponseException::create($response);
        }
        
        return $response;
    }
}
