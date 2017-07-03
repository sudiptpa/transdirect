<?php

namespace Sujip\Transdirect\Test;

use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Sujip\Transdirect\Transdirect;

class TransdirectTest extends TestCase
{
    /** @test */
    public function testInstanceOf()
    {
        $client = new Transdirect('cgfi7gagaf76');

        $this->assertInstanceOf(Transdirect::class, $client);
    }

    /**
     * @param $response
     * @param $endpoint
     * @param $parameters
     *
     * @return mixed
     */
    private function mockGuzzleRequest($response, $endpoint, $parameters)
    {
        $mockResponse = $this->getMockBuilder(ResponseInterface::class)
            ->getMock();
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($response);

        $mockGuzzle = $this->getMockBuilder(GuzzleClient::class)
            ->setMethods(['post'])
            ->getMock();
        $mockGuzzle->expects($this->once())
            ->method('post')
            ->with($endpoint, $parameters)
            ->willReturn($mockResponse);

        return $mockGuzzle;
    }
}
