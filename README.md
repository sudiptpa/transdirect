## Transdirect API client

[![CI](https://github.com/sudiptpa/transdirect/actions/workflows/ci.yml/badge.svg)](https://github.com/sudiptpa/transdirect/actions/workflows/ci.yml)
[![Latest Stable Version](https://poser.pugx.org/sudiptpa/transdirect/v/stable?format=flat)](https://packagist.org/packages/sudiptpa/transdirect)
[![Total Downloads](https://poser.pugx.org/sudiptpa/transdirect/downloads?format=flat)](https://packagist.org/packages/sudiptpa/transdirect)
[![License](https://poser.pugx.org/sudiptpa/transdirect/license?format=flat)](https://packagist.org/packages/sudiptpa/transdirect)

A clean, dependency-free PHP client for the Transdirect REST API.

- PHP 7.0+
- no runtime HTTP dependency
- fluent resource API
- configurable live and sandbox endpoints
- transport injection for tests

### Install

```bash
composer require sudiptpa/transdirect
```

### Quick start

```php
use Sujip\Transdirect\Transdirect;

$client = Transdirect::connect($apiKey);

$response = $client->quotes()->create([
    'declared_value' => '1000.00',
    'referrer' => 'API',
    'requesting_site' => 'https://example.com.au',
    'items' => [
        [
            'weight' => '38.63',
            'height' => '0.25',
            'width' => '1.65',
            'length' => '3.32',
            'quantity' => 1,
            'description' => 'carton',
        ],
    ],
    'sender' => [
        'address' => '21 Kirksway Place',
        'company_name' => 'Sender Company',
        'email' => 'sender@example.com',
        'name' => 'Sender Name',
        'postcode' => '2000',
        'phone' => '0212345678',
        'state' => 'NSW',
        'suburb' => 'SYDNEY',
        'type' => 'business',
        'country' => 'AU',
    ],
    'receiver' => [
        'address' => '216 Moggill Rd',
        'company_name' => 'Receiver Company',
        'email' => 'receiver@example.com',
        'name' => 'Receiver Name',
        'postcode' => '3000',
        'phone' => '0312345678',
        'state' => 'VIC',
        'suburb' => 'MELBOURNE',
        'type' => 'business',
        'country' => 'AU',
    ],
]);

$quotes = $response->getQuotes();
```

### Resources

```php
$client->quotes()->create($payload);
$client->bookings()->create($payload);
$client->bookings()->find($bookingId);
$client->bookings()->update($bookingId, $payload);
$client->bookings()->delete($bookingId);
$client->bookings()->action($bookingId, 'confirm', $payload);
$client->bookings()->nested($bookingId, 'label');
$client->orders()->create($payload);
$client->locations()->get(['q' => 'Sydney']);
$client->couriers()->get();
$client->member()->get();
$client->frequentRates()->get();
```

### Helpers

```php
$client->tracking($bookingId);
$client->postcode('3000');
$client->pagedLocations(2);
```

### Sandbox

```php
$client = Transdirect::connect($apiKey)
    ->setSandboxEndpoint('https://sandbox.example.test/api')
    ->useSandbox();
```

Sandbox mode now requires an explicit sandbox endpoint.

### Custom transport

```php
$client = new Transdirect($apiKey, function ($method, $url, $headers, $body) {
    return [
        'status' => 200,
        'headers' => ['Content-Type' => 'application/json'],
        'body' => '{"ok":true}',
    ];
});
```

### Testing

```bash
composer test
composer stan
find src tests -name '*.php' -print0 | xargs -0 -n1 php -l
```

### Docs

https://www.transdirect.com.au/education/developers-centre/
