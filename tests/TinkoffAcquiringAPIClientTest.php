<?php
use JustCommunication\TinkoffAcquiringAPIClient\TinkoffAcquiringAPIClient;

class TinkoffAcquiringAPIClientTest extends PHPUnit_Framework_TestCase
{
    public function testCallUndefinedMethod()
    {
        $client = new TinkoffAcquiringAPIClient('token', 'secret');

        $this->expectException(BadMethodCallException::class);
        $client->callSomeUndefinedRequest(new \JustCommunication\TinkoffAcquiringAPIClient\API\GetStateRequest(123));
    }

    public function testCreateHttpClientWithDefault()
    {
        $client = new TinkoffAcquiringAPIClient('token', 'secret');

        $this->assertEquals(10, $client->getHttpClient()->getConfig('timeout'));
    }

    public function testCreateHttpClientWithArray()
    {
        $client = new TinkoffAcquiringAPIClient('token', 'secret', [
            'timeout' => 20
        ]);

        $this->assertEquals(20, $client->getHttpClient()->getConfig('timeout'));
    }

    public function testCreateHttpClientWithCustomHttpClient()
    {
        $httpClient = new \GuzzleHttp\Client([
            'timeout' => 15
        ]);

        $client = new TinkoffAcquiringAPIClient('token', 'secret', $httpClient);
        $this->assertEquals(15, $client->getHttpClient()->getConfig('timeout'));

        $httpClient = new \GuzzleHttp\Client([
            'timeout' => 25
        ]);

        $client = new TinkoffAcquiringAPIClient('token', 'secret');
        $this->assertEquals(10, $client->getHttpClient()->getConfig('timeout'));

        $client->setHttpClient($httpClient);
        $this->assertEquals(25, $client->getHttpClient()->getConfig('timeout'));
    }
}
