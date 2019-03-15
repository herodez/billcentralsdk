<?php

namespace BillSDK;

use BillSDK\Exceptions\BillNotFoundException;
use BillSDK\Exceptions\InvalidTransactionCodeException;
use BillSDK\HttpClients\BillCentralGuzzleClient;

class BillClient
{
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
	 * @param $options
	 */
	public function __construct($options)
	{
		$this->client = new BillCentralGuzzleClient([
			'token' => $options['token']
		]);
	}
	
	// TODO: Validate if the following methods are necessary.
	/**
	 * Validate a bill code pass.
	 *
	 * @param $bill
	 * @return mixed
	 * @throws BillNotFoundException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function validateBill($bill)
	{
		$response = $this->client->makeRequest('POST', config('config.endpoints.validateBill'),[
			'bill' => $bill
		]);
	
		if($response->status === 'CODE_NOT_FOUND'){
			throw new BillNotFoundException();
		}
		
		return $response;
	}
	
	/**
	 * Redeem a bill by it's transaction code.
	 *
	 * @param $transactionCode
	 * @return mixed
	 * @throws InvalidTransactionCodeException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function redeemBill($transactionCode)
	{
		$response = $this->client->makeRequest('POST', config('config.endpoints.redeemBill'),[
			'transaction_code' => $transactionCode
		]);
		
		if($response->status === 'INVALID_TRANSACTION_CODE'){
			throw new InvalidTransactionCodeException();
		}
		
		return $response;
	}
	
	/**
	 * Validate and redeem a bill code.
	 *
	 * @param $bill
	 * @return mixed
	 * @throws BillNotFoundException
	 * @throws InvalidTransactionCodeException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function validateAndRedeemCode($bill)
	{
		$response = $this->validateBill($bill);
		return $this->redeemBill($response->data->transaction_code);
	}
}