<?php

namespace Sujip\Transdirect\Http;

use Sujip\Transdirect\Endpoint;
use Sujip\Transdirect\Exceptions\BadRequest;
use Sujip\Transdirect\Exceptions\RequestException;
use Sujip\Transdirect\Response;

class Request
{
    use Endpoint;

    protected $token;
    protected $transport;
    protected $timeout = 30;

    public function __construct($token, $transport = null)
    {
        $this->token = $token;
        $this->transport = $transport;
    }

    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    public function timeout($seconds)
    {
        $this->timeout = (int) $seconds;

        return $this;
    }

    public function make($uri, array $parameters = [], $method = 'post')
    {
        $method = strtoupper($method);
        $url = $this->getEndpoint($uri);
        $body = null;

        if ($method === 'GET' && !empty($parameters)) {
            $url = $this->appendQuery($url, $parameters);
        } elseif (!empty($parameters) || in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            $body = json_encode($parameters);
        }

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Api-Key' => $this->token,
        ];

        return $this->send($method, $url, $headers, $body);
    }

    protected function send($method, $url, array $headers, $body = null)
    {
        if ($this->transport) {
            $response = $this->sendUsingTransport($method, $url, $headers, $body);
        } elseif (function_exists('curl_init')) {
            $response = $this->sendUsingCurl($method, $url, $headers, $body);
        } else {
            $response = $this->sendUsingStreams($method, $url, $headers, $body);
        }

        if ($response->getCode() >= 400) {
            throw new BadRequest($response);
        }

        return $response;
    }

    protected function sendUsingTransport($method, $url, array $headers, $body = null)
    {
        if (is_callable($this->transport)) {
            $response = call_user_func($this->transport, $method, $url, $headers, $body);
        } elseif (is_object($this->transport) && method_exists($this->transport, 'send')) {
            $response = $this->transport->send($method, $url, $headers, $body);
        } else {
            throw new RequestException('Invalid Transdirect transport. Expected a callable or an object with a send method.');
        }

        return $this->normalizeResponse($response);
    }

    protected function sendUsingCurl($method, $url, array $headers, $body = null)
    {
        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_HEADER, true);
        curl_setopt($handle, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $this->formatHeaders($headers));

        if ($body !== null) {
            curl_setopt($handle, CURLOPT_POSTFIELDS, $body);
        }

        $raw = curl_exec($handle);

        if ($raw === false) {
            $message = curl_error($handle);
            curl_close($handle);

            throw new RequestException($message);
        }

        $status = (int) curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $headerSize = (int) curl_getinfo($handle, CURLINFO_HEADER_SIZE);
        curl_close($handle);

        return new Response(
            $status,
            $this->parseHeaders(substr($raw, 0, $headerSize)),
            substr($raw, $headerSize)
        );
    }

    protected function sendUsingStreams($method, $url, array $headers, $body = null)
    {
        $context = stream_context_create([
            'http' => [
                'method' => $method,
                'header' => implode("\r\n", $this->formatHeaders($headers)),
                'content' => $body === null ? '' : $body,
                'ignore_errors' => true,
                'timeout' => $this->timeout,
            ],
        ]);

        $responseBody = @file_get_contents($url, false, $context);

        if ($responseBody === false) {
            throw new RequestException('Unable to connect to Transdirect API.');
        }

        $rawHeaders = implode("\r\n", $http_response_header);

        return new Response(
            $this->parseStatusCode($rawHeaders),
            $this->parseHeaders($rawHeaders),
            $responseBody
        );
    }

    protected function normalizeResponse($response)
    {
        if ($response instanceof Response) {
            return $response;
        }

        if (is_array($response)) {
            return new Response(
                isset($response['status']) ? (int) $response['status'] : 200,
                isset($response['headers']) ? (array) $response['headers'] : [],
                isset($response['body']) ? (string) $response['body'] : ''
            );
        }

        return new Response(200, [], (string) $response);
    }

    protected function appendQuery($url, array $query)
    {
        $separator = strpos($url, '?') === false ? '?' : '&';

        return $url.$separator.http_build_query($query, '', '&');
    }

    protected function formatHeaders(array $headers)
    {
        $formatted = [];

        foreach ($headers as $key => $value) {
            $formatted[] = $key.': '.$value;
        }

        return $formatted;
    }

    protected function parseHeaders($rawHeaders)
    {
        $headers = [];
        $lines = preg_split('/\r\n|\r|\n/', trim($rawHeaders));

        foreach ($lines as $line) {
            if (strpos($line, ':') === false) {
                continue;
            }

            list($key, $value) = explode(':', $line, 2);
            $headers[trim($key)] = trim($value);
        }

        return $headers;
    }

    protected function parseStatusCode($rawHeaders)
    {
        if (preg_match('/HTTP\/\S+\s+(\d+)/', $rawHeaders, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }
}
