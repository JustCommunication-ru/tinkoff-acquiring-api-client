<?php

use JustCommunication\TinkoffAcquiringAPIClient\API\GetStateRequest;

class GetStateRequestTest extends PHPUnit_Framework_TestCase
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