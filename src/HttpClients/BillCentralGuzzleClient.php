<?php

namespace BillSDK\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class BillCentralGuzzleClient
{
	private $client;
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
			'base_uri' => config('config.baseURI')
		]);
		
		$this->baseRequest = [
			'json' => [
				'token' => $options['token'],
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
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function makeRequest($method, $path, $data)
	{
		$response = $this->client->request($method, $path, $this->preparedRequest($data));
		return $this->formatResponse($response);
	}
	
	/**
	 * Format the response body.
	 *
	 * @param Response $response
	 * @return mixed
	 */
	private function formatResponse(Response $response)
	{
		return json_decode($response->getBody());
	}
}
