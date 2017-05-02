<?php

namespace Sujip\Transdirect\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Sujip\Transdirect\Endpoint;
use Sujip\Transdirect\Exceptions\BadRequest;
use Sujip\Transdirect\Response;

/**
 * This is the client class.
 *
 * @author Sujip Thapa <support@sujipthapa.co>
 */
class Request
{
    use Endpoint;

    /**
     * The API token.
     *
     * @var string
     */
    protected $token;

    /**
     * The guzzle http client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Create a new request instance.
     *
     * @param string             $token
     * @param \GuzzleHttp\Client $client
     *
     * @return void
     */
    public function __construct($token, ClientInterface $client = null)
    {
        $this->token = $token;

        $this->client = $client ?: new Client();
    }

    /**
     * @param string $uri
     * @param array  $parameters
     * @param string $method
     *
     * @return \Sujip\Transdirect\Response
     */
    public function make($uri, array $parameters = [], $method = 'post')
    {
        $url = $this->getEndpoint($uri);

        $parameters = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Api-Key' => $this->token,
            ],
            'body' => json_encode($parameters),
        ];

        try {
            $response = $this->client->{$method}($url, $parameters);
        } catch (ClientException $exception) {
            if (in_array($exception->getResponse()->getStatusCode(), [400, 409])) {
                return new BadRequest($exception->getResponse());
            }

            return $exceptbion;
        }

        return new Response($response);
    }
}
