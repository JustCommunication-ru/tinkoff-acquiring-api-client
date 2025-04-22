<?php

namespace Tests\API;

use JustCommunication\TinkoffAcquiringAPIClient\API\GetStateRequest;
use PHPUnit\Framework\TestCase;

class GetStateRequestTest extends TestCase
{
    public function testCreate()
    {
        $request = new GetStateRequest('123');

        $this->assertEquals('POST', $request->getHttpMethod());
        $this->assertEquals('GetState', $request->getUri());
        $this->assertEquals([
            'json' => [
                'PaymentId' => '123'
            ]
        ], $request->createHttpClientParams());

        $request->setIP('192.168.1.1');

        $this->assertEquals([
            'json' => [
                'PaymentId' => '123',
                'IP' => '192.168.1.1'
            ]
        ], $request->createHttpClientParams());
    }
}