<?php

namespace Tests\API;

use DateTime;
use JustCommunication\TinkoffAcquiringAPIClient\API\InitRequest;
use JustCommunication\TinkoffAcquiringAPIClient\Model\ReceiptFFD105;
use JustCommunication\TinkoffAcquiringAPIClient\Model\ReceiptFFD12;
use JustCommunication\TinkoffAcquiringAPIClient\Model\ReceiptFFD12ClientInfo;
use JustCommunication\TinkoffAcquiringAPIClient\Model\ReceiptItemFFD105;
use JustCommunication\TinkoffAcquiringAPIClient\Model\ReceiptItemFFD12;
use JustCommunication\TinkoffAcquiringAPIClient\Model\ReceiptPayments;
use PHPUnit\Framework\TestCase;

class InitRequestTest extends TestCase
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

        $redirectDueDate = new DateTime();
        $request->setRedirectDueDate(new DateTime());

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
                'RedirectDueDate' => $redirectDueDate->format(DateTime::ISO8601),
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
                'RedirectDueDate' => $redirectDueDate->format(DateTime::ISO8601),
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

    public function testCreateWithReceiptFFD105()
    {
        $request = new InitRequest(1000, '123');
        $request->setPayType($request::PAY_TYPE_TWO_STAGE);

        $receipt = new ReceiptFFD105('test@test.ru', '89681111111', ReceiptFFD105::TAXATION_OSN, [
            new ReceiptItemFFD105('Первая позиция', 1000, 2, ReceiptFFD105::TAXATION_OSN),
            new ReceiptItemFFD105('Вторая позиция', 500, 3, ReceiptFFD105::TAXATION_USN_INCOME, 'advance', 'excise', 'test-ean-13', 'test-shop', 'шт'),
        ]);

        $request->setReceipt($receipt);

        $this->assertEquals([
            'json' => [
                'OrderId' => '123',
                'Amount' => 1000,
                'PayType' => 'T',
                'Receipt' => [
                    'FfdVersion' => '1.05',
                    'Items' => [
                        [
                            'Name' => 'Первая позиция',
                            'Price' => 1000,
                            'Quantity' => 2,
                            'Amount' => 2000,
                            'Tax' => 'osn'
                        ],
                        [
                            'Name' => 'Вторая позиция',
                            'Price' => 500,
                            'Quantity' => 3,
                            'Amount' => 1500,
                            'Tax' => 'usn_income',
                            'PaymentMethod' => 'advance',
                            'PaymentObject' => 'excise',
                            'MeasurementUnit' => 'шт',
                            'Ean13' => 'test-ean-13',
                            'ShopCode' => 'test-shop'
                        ]
                    ],
                    'Email' => 'test@test.ru',
                    'Phone' => '89681111111',
                    'Taxation' => 'osn'
                ]
            ]
        ], json_decode(json_encode($request->createHttpClientParams()), true));
    }

    public function testCreateWithReceiptFFD12()
    {
        $request = new InitRequest(1000, '123');
        $request->setPayType($request::PAY_TYPE_TWO_STAGE);

        $receipt = new ReceiptFFD12('test@test.ru', '89681111111', ReceiptFFD105::TAXATION_OSN, [
            new ReceiptItemFFD12('Первая позиция', 1000, 2, ReceiptFFD105::TAXATION_OSN, null, 'excise'),
            new ReceiptItemFFD12('Вторая позиция', 500, 3, ReceiptFFD105::TAXATION_USN_INCOME, 'advance', 'excise', 'test-ean-13', 'test-shop', 'шт'),
        ]);

        $clientInfo = new ReceiptFFD12ClientInfo();
        $clientInfo
            ->setBirthdate(new DateTime())
            ->setAddress('Test address')
        ;

        $receipt->setClientInfo($clientInfo);

        $receiptPayments = new ReceiptPayments();
        $receiptPayments
            ->setElectronic(100)
            ->setCash(100)
        ;

        $receipt->setPayments($receiptPayments);

        $request->setReceipt($receipt);

        $this->assertEquals([
            'json' => [
                'OrderId' => '123',
                'Amount' => 1000,
                'PayType' => 'T',
                'Receipt' => [
                    'FfdVersion' => '1.2',
                    'Items' => [
                        [
                            'Name' => 'Первая позиция',
                            'Price' => 1000,
                            'Quantity' => 2,
                            'Amount' => 2000,
                            'Tax' => 'osn',
                            'PaymentObject' => 'excise',
                        ],
                        [
                            'Name' => 'Вторая позиция',
                            'Price' => 500,
                            'Quantity' => 3,
                            'Amount' => 1500,
                            'Tax' => 'usn_income',
                            'PaymentMethod' => 'advance',
                            'PaymentObject' => 'excise',
                            'MeasurementUnit' => 'шт',
                            'Ean13' => 'test-ean-13',
                            'ShopCode' => 'test-shop'
                        ]
                    ],
                    'Email' => 'test@test.ru',
                    'Phone' => '89681111111',
                    'Taxation' => 'osn',
                    'ClientInfo' => [
                        'Birthdate' => (new DateTime())->format('d.m.Y'),
                        'Address' => 'Test address',
                    ],
                    'Payments' => [
                        'Cash' => 100,
                        'Electronic' => 100
                    ]
                ]
            ]
        ], json_decode(json_encode($request->createHttpClientParams()), true));
    }
}
