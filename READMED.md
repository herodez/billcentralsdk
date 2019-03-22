# Bill-Central SDK for PHP

[![Latest Stable Version](http://img.shields.io/badge/Latest%20Stable-1.0.0-green.svg)](http://optgit.optimeconsulting.net:8090/mgonzalez/billcentralsdk)

This repository contains a SDK that allows you to access the Bill-Central Platform from your PHP app.

## Installation

The Bill-Central PHP SDK can be installed with [Composer](https://getcomposer.org/). making the following configurations
in your **composer.json** file:

```json
 "require":{
    "optime/billcentralsdk":"dev-1.0.0"
 },
 "config":{
    "secure-http": false
 },
 "repositories": [
      {
        "type": "vcs",
        "url":  "http://optgit.optimeconsulting.net:8090/mgonzalez/billcentralsdk"
      }
 ]
```
and run this command

```sh
composer install optime/billCentralSDK
```
## Usage

> **Note:** This version of the Bill-Central SDK for PHP requires PHP 5.4 or greater.

Simple bill redeem.

```php
require 'vendor/autoload.php';

use BillCentralSDK\Client;
use BillCentralSDK\Exceptions\BillCentralSDKException;

$billCentral = new Client([
    'api_key' => '{loyalty_api_key}',
]);

try {

    // Create a new Bill redeem transaction.
    $transaction = $billCentral->newTransaction([
        'bill' => [
            'code' => 'BCCO1234A324',
            'purpose' => 'training'
        ],
        'company_id' => 1
    ]);
    
    // Loyalty logic.
    
    // Complete transaction redeem.
    $response = $transaction->complete([
        'id' => 30,
        'email' => 'example@test.com',
        'point_id' => 1223
        'company_id' => 1
    ]);
    
    echo "Transaction OK";
    
} catch (BillCentralSDKException $e) {
    echo $e->getMessage();
    die();
}
```

Complete documentation, installation instructions, and examples are available [here](docs/).

## Security Vulnerabilities

If you have found a security issue, please contact the maintainers directly at [mgonzalez@optimeconsulting.com](mailto:mgonzalez@optimeconsulting.com).