<?php

use Sujip\Transdirect\Transdirect;

require __DIR__ . '/vendor/autoload.php';

$transdirect = new Transdirect('1f5b8d2ff0820c7fbc24a8ba824e01a8');

$transdirect->sandbox();

$payload = [
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
        'company_name' => 'Digital Thinker Pvt. Ltd.',
        'email' => 'sudiptpa@gmail.com',
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
        'company_name' => 'Digital Thinker Pvt. Ltd.',
        'email' => 'support@digitalthinker.co',
        'name' => 'John Smith',
        'postcode' => '3000',
        'phone' => 123456789,
        'state' => '',
        'suburb' => 'MELBOURNE',
        'type' => 'business',
        'country' => 'AU',
    ],
];

$confirm = [
    'courier' => 'allied',
    'pickup-date' => '2015-08-27',
];

$item = [
    'weight' => 11,
    'height' => 11,
    'width' => 11,
    'length' => 11,
    'quantity' => 5,
    'description' => 'carton',
];

$create_order = [
    'transdirect_order_id' => 12345,
    'order_id' => '4444',
    'goods_summary' => 'This is a test',
    'goods_dump' => 'Another test',
    'imported_from' => 'API',
    'purchased_time' => '2015-06-01T16 =>06 =>52+1000',
    'sale_price' => 10.2,
    'selected_courier' => 'toll',
    'paid_time' => '2015-06-01T16 =>06 =>52+1000',
    'buyer_name' => 'John Doe',
    'buyer_email' => 'john@testemail.com.au',
    'delivery' => [
        'name' => 'John Doe',
        'email' => '',
        'phone' => '123456789',
        'address' => '216 Moggill Rd',
    ],
];

$update_order = [
    'transdirect_order_id' => 12345,
    'order_id' => '4444',
    'goods_summary' => 'This is a test',
    'goods_dump' => 'Another test',
    'imported_from' => 'API',
    'purchased_time' => '2015-06-01T16:06:52+1000',
    'sale_price' => 10.2,
    'selected_courier' => 'toll',
    'paid_time' => '2015-06-01T16:06:52+1000',
    'buyer_name' => 'John Doe',
    'buyer_email' => 'john@testemail.com.au',
    'delivery' => [
        'name' => 'John Doe',
        'email' => '',
        'phone' => '123456789',
        'address' => '216 Moggill Rd',
    ],
];

$response = $transdirect->simpleQuotes($payload);

echo '<pre>';

print_r($response->toJson());
