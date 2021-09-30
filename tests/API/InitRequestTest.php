<?php

use JustCommunication\TinkoffAcquiringAPIClient\API\InitRequest;

class InitRequestTest extends PHPUnit_Framework_TestCase
{
    public function testCreateWithMinimumParameters()
    {
        $request = new InitRequest(1000, '123');

        $this->assertEquals('POST', $request->getHttpMethod());
        $this->assertEquals('Init', $request->getUri());
        $this->assertEquals([
            'json' => [
                'OrderId' => '123',
                'Amount' => 1000
            ]
        ], $request->createHttpClientParams());
    }

    public function testCreateWithAllParameters()
    {
        $request = new InitRequest(1000, '123');
        $request
            ->setAmount(1010)
            ->setOrderId('124')
            ->setIP('192.168.1.1')
            ->setDescription('Описание транзакции')
            ->setLanguage($request::LANGUAGE_RU)
            ->setRecurrent('2')
            ->setCustomerKey('3')
            ->setNotificationURL('https://domain.tld/_api/notifications/124')
            ->setSuccessURL('https://domain.tld/_api/success/124')
            ->setFailURL('https://domain.tld/_api/fail/124')
            ->setPayType($request::PAY_TYPE_ONE_STAGE)
            ->setData([
                'Foo' => 'bar'
            ])
        ;

        $request->addData('Bar', 'baz');

        $redirectDueDate = new \DateTime();
        $request->setRedirectDueDate(new \DateTime());

        $this->assertEquals('POST', $request->getHttpMethod());
        $this->assertEquals('Init', $request->getUri());
        $this->assertEquals([
            'json' => [
                'OrderId' => '124',
                'Amount' => 1010,
                'IP' => '192.168.1.1',
                'Description' => 'Описание транзакции',
                'Language' => 'ru',
                'Recurrent' => '2',
                'CustomerKey' => '3',
                'RedirectDueDate' => $redirectDueDate->format(\DateTime::ISO8601),
                'NotificationURL' => 'https://domain.tld/_api/notifications/124',
                'SuccessURL' => 'https://domain.tld/_api/success/124',
                'FailURL' => 'https://domain.tld/_api/fail/124',
                'PayType' => 'O',
                'DATA' => [
                    'Foo' => 'bar',
                    'Bar' => 'baz'
                ]
            ]
        ], $request->createHttpClientParams());

        $request->removeData('Foo');

        $this->assertEquals([
            'json' => [
                'OrderId' => '124',
                'Amount' => 1010,
                'IP' => '192.168.1.1',
                'Description' => 'Описание транзакции',
                'Language' => 'ru',
                'Recurrent' => '2',
                'CustomerKey' => '3',
                'RedirectDueDate' => $redirectDueDate->format(\DateTime::ISO8601),
                'NotificationURL' => 'https://domain.tld/_api/notifications/124',
                'SuccessURL' => 'https://domain.tld/_api/success/124',
                'FailURL' => 'https://domain.tld/_api/fail/124',
                'PayType' => 'O',
                'DATA' => [
                    'Bar' => 'baz'
                ]
            ]
        ], $request->createHttpClientParams());
    }

    public function testCreateWithUnknownLanguage()
    {
        $request = new InitRequest(1000, '123');
        $request->setLanguage($request::LANGUAGE_EN);

        $this->assertEquals([
            'json' => [
                'OrderId' => '123',
                'Amount' => 1000,
                'Language' => 'en'
            ]
        ], $request->createHttpClientParams());

        $request->setLanguage('UNKNOWN');

        $this->assertEquals([
            'json' => [
                'OrderId' => '123',
                'Amount' => 1000
            ]
        ], $request->createHttpClientParams());
    }

    public function testCreateWithPayTypeLanguage()
    {
        $request = new InitRequest(1000, '123');
        $request->setPayType($request::PAY_TYPE_TWO_STAGE);

        $this->assertEquals([
            'json' => [
                'OrderId' => '123',
                'Amount' => 1000,
                'PayType' => 'T'
            ]
        ], $request->createHttpClientParams());

        $request->setPayType('UNKNOWN');

        $this->assertEquals([
            'json' => [
                'OrderId' => '123',
                'Amount' => 1000
            ]
        ], $request->createHttpClientParams());
    }
}