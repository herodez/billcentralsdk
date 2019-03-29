# Bill-Central Client

This example cover a bill central client creation with BC SDK.

```php
$billCentral = new BillCentralSDK\Client([
    'api_key' => '{loyalty_api_key}',
    'timeout' => 60,
    'base_uri' => '{Base URI of the server}'
])
```
The previous example create a Bill-Central client with the loyalty **api_key** and with a **timeout**
that wait to 60 seconds for each request.  

---
## Parameters 
- api_key (required): Loyalty API key to authentication requests.
- timeout (optional): Set the timeout of every request. 
- base_uri (optional): Set the base URI of the bill-central platform if it's need.
