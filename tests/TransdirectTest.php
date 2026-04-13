<?php

namespace Sujip\Transdirect\Test;

use PHPUnit\Framework\TestCase;
use Sujip\Transdirect\Exceptions\BadRequest;
use Sujip\Transdirect\Exceptions\RequestException;
use Sujip\Transdirect\Response;
use Sujip\Transdirect\Transdirect;

class TransdirectTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $client = Transdirect::connect('test-key');

        $this->assertInstanceOf(Transdirect::class, $client);
    }

    public function test_it_sends_fluent_requests()
    {
        $calls = [];
        $client = Transdirect::connect('test-key', function ($method, $url, $headers, $body) use (&$calls) {
            $calls[] = compact('method', 'url', 'headers', 'body');

            return [
                'status' => 200,
                'headers' => ['Content-Type' => 'application/json'],
                'body' => '{"id":"B123","quotes":{"tnt":{"service":"road","transit_time":"1 day","total":"10.00","fee":"1.00","price_insurance_ex":"0.00","insured_amount":"0"}}}',
            ];
        });

        $response = $client->quotes()->create(['declared_value' => '100.00']);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('POST', $calls[0]['method']);
        $this->assertSame('https://www.transdirect.com.au/api/quotes', $calls[0]['url']);
        $this->assertSame('B123', $response->getId());
    }

    public function test_sandbox_requires_explicit_endpoint()
    {
        $this->expectException(RequestException::class);

        Transdirect::connect('test-key', function () {
            return ['status' => 200, 'body' => '{}'];
        })->useSandbox()->member()->get();
    }

    public function test_http_errors_raise_bad_request()
    {
        $this->expectException(BadRequest::class);

        Transdirect::connect('test-key', function () {
            return [
                'status' => 422,
                'body' => '{"error_summary":"Invalid request."}',
            ];
        })->quotes()->create([]);
    }
}
