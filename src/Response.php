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
    public function getBody()
    {
        return $this->response->getBody();
    }

    /**
     * @return null
     */
    public function getQuotes()
    {
        $body = $this->getJson();

        if (isset($body->quotes)) {
            return $body->quotes;
        }

        return null;
    }

    public function getJson()
    {
        return json_encode($this->response->getBody());
    }

    public function getArray()
    {
        return json_decode($this->response->getBody(), true);
    }
}
