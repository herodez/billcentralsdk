# Redeem transaction

This example cover how to redeem a bill code with BC SDK.

```php
 $transaction = $billCentral->newTransaction([
    'bill' => [
        'code' => '{bill_code}',
        'purpose' => '{bill_purpous}'
    ],
    'company_id' => '{company_id}'
 ]);
 
 $response = $transaction->complete([
    'id' => 30,
    'email' => 'example@test.com',
    'point_id' => 1223
    'company_id' => 1
 ])
```
The previous example use a Bill-Central client to redeem a bill code, first this create 
a new BillTransaction with necessary bill and company data and then complete the transaction with
the data of the user and point reference.

## Parameters

#### New transaction.

- bill: Associative array that contains the bill code data.
- company_id: Company id reference that apply the bill code if is necessary.

#### Complete a transaction.

- id: User id reference.
- email: User email reference.
- point_id: User point id reference.
- company_id: Company id reference that apply the bill code if is necessary.
