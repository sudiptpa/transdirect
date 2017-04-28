<?php

use Sujip\Transdirect\Transdirect;

require __DIR__ . '/vendor/autoload.php';

$transdirect = new Transdirect('54930ccecc794e88649bdfa28a8ead99');

$transdirect->sandbox();

$payload = [
    "declared_value" => "1000.00",
    "items" => [
        [
            "weight" => "38.63",
            "height" => "0.25",
            "width" => "1.65",
            "length" => "3.32",
            "quantity" => 1,
            "description" => "carton",
        ],
        [

            "weight" => "39.63",
            "height" => "1.25",
            "width" => "2.65",
            "length" => "4.32",
            "quantity" => 2,
            "description" => "carton",
        ],
    ],
    "sender" => [
        "postcode" => "2000",
        "suburb" => "SYDNEY",
        "type" => "business",
        "country" => "AU",
    ],
    "receiver" => [

        "postcode" => "3000",
        "suburb" => "MELBOURNE",
        "type" => "business",
        "country" => "AU",
    ],
];

$confirm = [
    "courier" => "allied",
    "pickup-date" => "2015-08-27",
];

$item = [
    "weight" => 11,
    "height" => 11,
    "width" => 11,
    "length" => 11,
    "quantity" => 5,
    "description" => "carton",
];

$response = $transdirect->simpleQuotes($payload);
$response = $transdirect->searchLocations('highton');

echo "<pre>";

print_r($response->getBody());


//only numbers
// $output = preg_replace( '/[^0-9]/', '', $string );