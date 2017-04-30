## A minimal implementation of Transdirect API v4.

Transdirect is Australia wide delivering solutions for you, this package covers a minimal PHP implementation of the Transdirect API v4. It contains only the endpoints documented at http://docs.transdirectapiv4.apiary.io.

### Requirements

This package requires PHP >=5.5

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
Also have a look in the [source code of `Sujip\Transdirect\Transdirect`](https://github.com/sudiptpa/transdirect/blob/master/src/Transdirect.php) to discover the methods you can use.

If you wish to make a direct call to API end point for your own custom implementation, you can use the `makeRequest` method.

```php
  $client->makeRequest('end-point', ['body' => json_encode($parameters)]);
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
