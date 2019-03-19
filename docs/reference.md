# Bill-Central SDK for PHP Reference (v1)

Below is the API reference for the Bill-Central SDK for PHP.

# Core API

These classes are at the core of the Bill-Central SDK for PHP.

| Class name  | Description |
| ------------- | ------------- |
| [`BillCentralSDK\Client`](/src/Client.php)  | The main service object that helps tie all the SDK components together.  |
| [`BillCentralSDK\BillTransaction`](/src/BillTransaction.php)  | An entity that represents a BillTransaction and manage all transaction logic. |

# Response

These classes are used in a Graph API request/response cycle.

| Class name  | Description |
| ------------- | ------------- |
| [`BillCentralSDK\BillCentralResponse`](/src/BillCentralResponse.php) | An entity that represents an HTTP response from the Bill-Central platform.  |


# Core Exceptions

These are the core exceptions that the SDK will throw when an error occurs.

| Class name  | Description |
| ------------- | ------------- |
| [`BillCentralSDK\Exceptions\BillCentralSDKException`](/src/Exceptions/BillCentralSDKException.php) | The base exception to all exceptions thrown by the SDK. Thrown when there is a non-Bill-Central-Platform-response-related error.  |
| [`BillCentralSDK\Exceptions\BillCentralResponseException`](/src/Exceptions/BillCentralResponseException.php)  | The base exception to all Bill-Central platform error responses. This exception is never thrown directly.  |

