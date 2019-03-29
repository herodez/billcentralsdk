# Redeem transaction

This example cover how to redeem a bill code with BC SDK.

```php
 $transaction = $billCentral->newTransaction([
    'bill' => [
        'code' => '{bill_code}',
        'purpose' => '{bill_purpous}'
    ],
 ]);
 
 $response = $transaction->complete([
      'user' => [
         'id' => 1,
         'email' => 'user@example.com',
      ],
      'references' => [
         'point_id' => 12,
         'company_id' => 2,
         'purpose' => 'Events'
      ]
 ]);
```
The previous example use a Bill-Central client to redeem a bill code, first this create 
a new BillTransaction with necessary bill and company data and then complete the transaction with
the data of the user and point reference.

## Parameters

#### New transaction.

- bill: Associative array that contains the bill data.

#### Complete a transaction.

- user: Associative array that contains the user data.
- references: Associative array that contains the references data.  
