<?php

namespace Sujip\Transdirect;

use GuzzleHttp\Message\Response as GuzzleHttpResponse;

/**
 * Class Response
 * @package Sujip\Transdirect
 */
class Response extends GuzzleHttpResponse
{
    /**
     * @var GuzzleHttp\Message\Response
     */
    protected $response;

    /**
     * @param GuzzleHttpResponse $response
     */
    public function __construct(GuzzleHttpResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getQuotes()
    {
        $body = $this->getBody();

        if (isset($body->quotes)) {
            return $body->quotes;
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        $body = (string) $this->response->getBody();

        return json_decode($body);
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->response->getStatusCode();
    }
}
