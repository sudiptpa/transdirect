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
     * @param string $token
     * @param GuzzleClient $client
     */
    public function __construct(string $token, GuzzleClient $client = null)
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
            throw $this->throwException($exception);
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
     * @return string
     */
    public function simpleQuotes(array $parameters)
    {
        return $this->makeRequest('quotes', ['body' => json_encode($parameters)]);
    }

    /**
     * @param $parameters
     * @return mixed
     */
    public function createBooking($parameters)
    {
        return $this->makeRequest('bookings', ['body' => json_encode($parameters)]);
    }

    /**
     * @param $parameters
     * @param $since
     * @param null $sort
     */
    public function getBookings($parameters, $since = null, $sort = null)
    {
        $uri = "bookings/?since={$since}&sort={$sort}";

        return $this->makeRequest($uri, ['body' => json_encode($parameters)], 'get');
    }

    /**
     * @param $parameters
     * @param $booking_id
     * @return string
     */
    public function getSingleBooking($parameters, $booking_id)
    {
        $uri = "bookings/{$booking_id}";

        return $this->makeRequest($uri, ['body' => json_encode($parameters)], 'get');
    }

    /**
     * @param $parameters
     * @param $booking_id
     * @return string
     */
    public function updateBooking($parameters, $booking_id)
    {
        $uri = "bookings/{$booking_id}";

        return $this->makeRequest($uri, ['body' => json_encode($parameters)], 'put');
    }

    /**
     * @param $booking_id
     */
    public function removeBooking($booking_id)
    {
        $uri = "bookings/{$booking_id}";

        return $this->makeRequest($uri, [], 'delete');
    }

    /**
     * @return mixed
     */
    public function getCouriers()
    {
        return $this->makeRequest('couriers', [], 'get');
    }
}
