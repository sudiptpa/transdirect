<?php

namespace Sujip\Transdirect;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Sujip\Transdirect\Exceptions\BadRequest;

/**
 * Class Transdirect
 * @package Sujip\Transdirect
 */
class Transdirect
{
    use Endpoint;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param $token
     * @param GuzzleClient $client
     */
    public function __construct($token, GuzzleClient $client = null)
    {
        $this->token = $token;

        $this->client = $client ?: new GuzzleClient([
            'headers' => [
                'Content-Type' => 'application/json',
                'Api-Key' => $this->token,
            ],
        ]);
    }

    /**
     * @param $uri
     * @param array $parameters
     * @param $method
     * @return \Sujip\Transdirect\Response
     */
    public function makeRequest($uri, array $parameters = [], $method = 'post')
    {
        $url = $this->getEndpoint($uri);

        try {
            $response = $this->client->{$method}($url, $parameters);
        } catch (ClientException $exception) {
            return [
                'error' => $exception->getMessage(),
                'status' => $exception->getResponse()->getStatusCode(),
            ];
        }

        return new Response($response);
    }

    /**
     * @param ClientException $exception
     * @return mixed
     */
    protected function throwException(ClientException $exception)
    {
        if (in_array($exception->getResponse()->getStatusCode(), [400, 409])) {
            return new BadRequest($exception->getResponse());
        }

        return $exception;
    }

    /**
     * @param array $parameters
     * @return \Sujip\Transdirect\Response
     */
    public function simpleQuotes(array $parameters)
    {
        return $this->makeRequest('quotes', ['body' => json_encode($parameters)]);
    }

    /**
     * @param $parameters
     * @return \Sujip\Transdirect\Response
     */
    public function createBooking($parameters)
    {
        return $this->makeRequest('bookings', ['body' => json_encode($parameters)]);
    }

    /**
     * @param $since
     * @param null $sort
     * @return \Sujip\Transdirect\Response
     */
    public function getBookings($since = null, $sort = null)
    {
        $uri = sprintf('bookings/?since=%s&sort=%s', $since, $sort);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $booking_id
     * @return \Sujip\Transdirect\Response
     */
    public function getSingleBooking($booking_id)
    {
        $uri = sprintf('bookings/%s', $booking_id);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $parameters
     * @param $booking_id
     * @return \Sujip\Transdirect\Response
     */
    public function updateBooking($parameters, $booking_id)
    {
        $uri = sprintf('bookings/%s', $booking_id);

        return $this->makeRequest($uri, ['body' => json_encode($parameters)], 'put');
    }

    /**
     * @param $booking_id
     * @return \Sujip\Transdirect\Response
     */
    public function removeBooking($booking_id)
    {
        $uri = sprintf('bookings/%s', $booking_id);

        return $this->makeRequest($uri, [], 'delete');
    }

    /**
     * @param $booking_id
     * @param $parameters
     * @return \Sujip\Transdirect\Response
     */
    public function confirmBooking($booking_id, $parameters)
    {
        $uri = sprintf('bookings/%s/confirm', $booking_id);

        return $this->makeRequest($uri, ['body' => json_encode($parameters)]);
    }

    /**
     * @param $booking_id
     * @return \Sujip\Transdirect\Response
     */
    public function trackBooking($booking_id)
    {
        $uri = sprintf('bookings/track/%s', $booking_id);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $booking_id
     * @return \Sujip\Transdirect\Response
     */
    public function getBookingItems($booking_id)
    {
        $uri = sprintf('bookings/%s/items', $booking_id);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $booking_id
     * @param $parameters
     * @return \Sujip\Transdirect\Response
     */
    public function addItemInBooking($booking_id, $parameters)
    {
        $uri = sprintf('bookings/%s/items', $booking_id);

        return $this->makeRequest($uri, ['body' => json_encode($parameters)]);
    }

    /**
     * @param $page
     * @return \Sujip\Transdirect\Response
     */
    public function getLocations($page = null)
    {
        $uri = 'bookings/locations';

        if (isset($page)) {
            $uri = sprintf($uri . "/page/%s", $page);
        }

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $query
     * @return \Sujip\Transdirect\Response
     */
    public function searchLocations($query = null)
    {
        $uri = sprintf('bookings/locations?q=%s', $query);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $query
     * @return \Sujip\Transdirect\Response
     */
    public function getByPostcode($query)
    {
        $uri = sprintf('locations/postcode/%s', $query);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $parameters
     * @return \Sujip\Transdirect\Response
     */
    public function createOrder($parameters)
    {
        return $this->makeRequest('orders', ['body' => json_encode($parameters)]);
    }

    /**
     * @param $since
     * @param null $sort
     * @return \Sujip\Transdirect\Response
     */
    public function getOrders($since = null, $sort = null)
    {
        $uri = sprintf('orders/?since=%s&sort=%s', $since, $sort);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $order_id
     * @return \Sujip\Transdirect\Response
     */
    public function getOrder($order_id)
    {
        $uri = sprintf('orders/%s', $order_id);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $order_id
     * @param $parameters
     * @return \Sujip\Transdirect\Response
     */
    public function updateOrder($order_id, $parameters)
    {
        $uri = sprintf('orders/%s', $order_id);

        return $this->makeRequest($uri, ['body' => json_encode($parameters)], 'put');
    }

    /**
     * @param $order_id
     * @return \Sujip\Transdirect\Response
     */
    public function removeOrder($order_id)
    {
        $uri = sprintf('orders/%s', $order_id);

        return $this->makeRequest($uri, ['body' => json_encode($parameters)], 'delete');
    }

    /**
     * @param $booking_id
     * @return \Sujip\Transdirect\Response
     */
    public function getPdfLabel($booking_id)
    {
        $uri = sprintf('bookings/%s/label', $booking_id);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $booking_id
     * @return \Sujip\Transdirect\Response
     */
    public function getInvoice($booking_id)
    {
        $uri = sprintf('bookings/%s/invoice', $booking_id);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @param $booking_id
     * @return \Sujip\Transdirect\Response
     */
    public function getTntLabel($booking_id)
    {
        $uri = sprintf('bookings/%s/tntregeneralabel', $booking_id);

        return $this->makeRequest($uri, [], 'get');
    }

    /**
     * @return \Sujip\Transdirect\Response
     */
    public function getCouriers()
    {
        return $this->makeRequest('couriers', [], 'get');
    }

    /**
     * @return \Sujip\Transdirect\Response
     */
    public function getMember()
    {
        return $this->makeRequest('member', [], 'get');
    }
}
