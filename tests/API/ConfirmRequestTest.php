<?php

use JustCommunication\TinkoffAcquiringAPIClient\API\ConfirmRequest;

class ConfirmRequestTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $request = new ConfirmRequest('123');

        $this->assertEquals('POST', $request->getHttpMethod());
        $this->assertEquals('Confirm', $request->getUri());
        $this->assertEquals([
            'json' => [
                'PaymentId' => '123'
            ]
        ], $request->createHttpClientParams());

        $request
            ->setAmount(1000)
            ->setIP('192.168.1.1')
        ;

        $this->assertEquals([
            'json' => [
                'PaymentId' => '123',
                'Amount' => 1000,
                'IP' => '192.168.1.1'
            ]
        ], $request->createHttpClientParams());
    }
}