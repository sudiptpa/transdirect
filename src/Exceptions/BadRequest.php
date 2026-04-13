<?php

namespace Sujip\Transdirect\Exceptions;

use Sujip\Transdirect\Response;

class BadRequest extends RequestException
{
    /**
     * @var \Sujip\Transdirect\Response
     */
    protected $response;

    /**
     * @param \Sujip\Transdirect\Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        $body = $response->toArray();
        $message = isset($body['error_summary']) ? $body['error_summary'] : 'Transdirect request failed.';

        parent::__construct($message, $response->getCode());
    }

    /**
     * @return \Sujip\Transdirect\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
