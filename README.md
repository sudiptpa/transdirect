## A minimal implementation of Transdirect API v4.

Transdirect is Australia wide delivering solutions for you, this package covers a minimal PHP implementation of the Transdirect REST API. It contains only the endpoints documented at http://docs.transdirectapiv4.apiary.io.

### Installation

You can install the package via composer: [Composer](http://getcomposer.org/).

```
composer require sudiptpa/transdirect
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

### Usage

The first thing you need to do is get the API token from [Transdirect](https://www.transdirect.com.au/), you will need to specify the requesting domain to get valid API response data.

Here are a few examples on how you can use the package:

```php
  $client = new Sujip\Transdirect\Transdirect($apiKey);  
```
Also have a look in the [source code of `Sujip\Transdirect\Transdirect`](https://github.com/sudiptpa/transdirect/blob/master/src/Transdirect.php) to discover the methods you can use. You will need to visit [Official REST API documentation](http://docs.transdirectapiv4.apiary.io) for the parameters to specify with each end point.

If you wish to make a direct call to API end point for your own custom implementation, you can use the `makeRequest` method.

```php
    $parameters = [
        'declared_value' => '1000.00',
        'referrer' => 'API',
        'requesting_site' => 'http://www.test.com.au',
        'tailgate_pickup' => true,
        'tailgate_delivery' => true,
        'items' => [
            ['weight' => '38.63',
                'height' => '0.25',
                'width' => '1.65',
                'length' => '3.32',
                'quantity' => 1,
                'description' => 'carton',
            ],
            [
                'weight' => '39.63',
                'height' => '1.25',
                'width' => '2.65',
                'length' => '4.32',
                'quantity' => 2,
                'description' => 'carton',
            ],
        ],
        'sender' => [
            'address' => '21 Kirksway Place',
            'company_name' => 'Test Company',
            'email' => 'sender@test.com',
            'name' => 'Sujip Thapa',
            'postcode' => '2000',
            'phone' => 123456789,
            'state' => '',
            'suburb' => 'SYDNEY',
            'type' => 'business',
            'country' => 'AU',
        ],
        'receiver' => [
            'address' => '216 Moggill Rd',
            'company_name' => 'Test Receiver',
            'email' => 'receiver@test.com',
            'name' => 'John Smith',
            'postcode' => '3000',
            'phone' => 123456789,
            'state' => '',
            'suburb' => 'MELBOURNE',
            'type' => 'business',
            'country' => 'AU',
        ],
    ];
    
  $response = $client->createBooking($parameters);
  $quotes = $response->getQuotes();
  $josn = $response->toJson();
  $bookingId = $response->getId();
  $statusCode = $response->getCode();
```

### Changelog

Please see [CHANGELOG](https://github.com/sudiptpa/transdirect/blob/master/CHANGELOG.md) for more information what has changed recently.

### Contributing

Contributions are **welcome** and will be fully **credited**.

Contributions can be made via a Pull Request on [Github](https://github.com/sudiptpa/paypal-ipn).



### Testing

If you would like to look at the real time response comming from live or mock server with transdirect REST API endpoints browse http://docs.transdirectapiv4.apiary.io



### Support

If you are having general issues with the package, feel free to drop me and email [sudiptpa@gmail.com](mailto:sudiptpa@gmail.com)

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/sudiptpa/paypal-ipn/issues),
or better yet, fork the library and submit a pull request.
