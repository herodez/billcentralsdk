# Bill-Central Client

This example cover a bill central client creation with BC SDK.

```php
$billCentral = new BillCentralSDK\Client([
    'api_key' => '{loyalty_api_key}' 
    'timeout' => 60
])
```
The previous example create a Bill-Central client with the loyalty **api_key** and with a **timeout**
that wait to 60 seconds for each request.  

---
## Parameters 
- api_key (required): Loyalty API key to authentication requests.
- timeout (optional): Set the timeout of every request. 
