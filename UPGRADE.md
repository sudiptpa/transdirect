## Upgrade guide

### 1. Constructor

Old:

```php
$client = new Transdirect($apiKey);
```

New:

```php
$client = Transdirect::connect($apiKey);
```

### 2. Quotes

Old:

```php
$client->simpleQuotes($payload);
```

New:

```php
$client->quotes()->create($payload);
```

### 3. Bookings

Old:

```php
$client->createBooking($payload);
$client->getSingleBooking($id);
$client->confirmBooking($id, $payload);
$client->getPdfLabel($id);
```

New:

```php
$client->bookings()->create($payload);
$client->bookings()->find($id);
$client->bookings()->action($id, 'confirm', $payload);
$client->bookings()->nested($id, 'label');
```

### 4. Orders

Old:

```php
$client->createOrder($payload);
$client->getOrder($id);
```

New:

```php
$client->orders()->create($payload);
$client->orders()->find($id);
```

### 5. Locations

Old:

```php
$client->searchLocations('Sydney');
$client->getByPostcode('3000');
```

New:

```php
$client->locations()->get(['q' => 'Sydney']);
$client->postcode('3000');
```

### 6. Sandbox

Old sandbox relied on a hardcoded Apiary mock.

New sandbox requires a real endpoint:

```php
$client->setSandboxEndpoint('https://sandbox.example.test/api')->useSandbox();
```
