# Tinkoff Acquiring API PHP Client

[![Latest Stable Version](https://poser.pugx.org/justcommunication-ru/tinkoff-acquiring-api-client/v)](//packagist.org/packages/justcommunication-ru/tinkoff-acquiring-api-client)
[![Latest Unstable Version](http://poser.pugx.org/justcommunication-ru/tinkoff-acquiring-api-client/v/unstable)](https://packagist.org/packages/justcommunication-ru/tinkoff-acquiring-api-client)
[![Total Downloads](https://poser.pugx.org/justcommunication-ru/tinkoff-acquiring-api-client/downloads)](//packagist.org/packages/justcommunication-ru/tinkoff-acquiring-api-client)
[![License](http://poser.pugx.org/justcommunication-ru/tinkoff-acquiring-api-client/license)](https://packagist.org/packages/justcommunication-ru/tinkoff-acquiring-api-client) 

PHP Клиент для интернет-эквайринга от Tinkoff

## Установка

`composer require justcommunication-ru/tinkoff-acquiring-api-client`

## Использование

```php
use JustCommunication\TinkoffAcquiringAPIClient\TinkoffAcquiringAPIClient;

$client = new TinkoffAcquiringAPIClient('<terminal-key>', '<secret>');
```

`<terminal-key>` — Идентификатор терминала. Выдается продавцу банком при заведении терминала

`<secret>` — ключ для подписи запросов

Далее вызываются доступные методы:

[Init](#Init) – создание платежа

[GetState](#GetState) – текущий статус платежа

[Confirm](#Confirm) – подтверждение платежа

[Cancel](#Cancel) – отмена платежа

## Методы

### Init

Метод создает платеж: продавец получает ссылку на платежную форму и должен перенаправить по ней покупателя

```php
use JustCommunication\TinkoffAcquiringAPIClient\API\InitRequest;
use JustCommunication\TinkoffAcquiringAPIClient\Exception\TinkoffAPIException;

// Запрос на создание платежа на 100 рублей и внутренним номером `order-1234`
$initRequest = new InitRequest(10000, 'order-1234');

// необязательные параметры
$initRequest
    ->setLanguage($initRequest::LANGUAGE_EN)
    ->setIP('192.168.1.1')
    ->setDescription('Описание транзакции')
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

$initRequest->addData('Bar', 'baz');

try {
    $response = $client->sendInitRequest($initRequest);
    //$response->getPaymentId() // идентификатор платежа

    header('Location: ' . $response->getPaymentURL()); // перенаправляем пользователя на страницу оплаты
    exit;
} catch (TinkoffAPIException $e) {
    // обработка ошибки
}
```

### GetState

Метод возвращает текущий статус платежа.

```php
use JustCommunication\TinkoffAcquiringAPIClient\API\GetStateRequest;
use JustCommunication\TinkoffAcquiringAPIClient\Exception\TinkoffAPIException;
use JustCommunication\TinkoffAcquiringAPIClient\Model\Payment;

$payment_id = '1234'; //Идентификатор платежа в системе банка
$request = new GetStateRequest($payment_id);

try {
    $response = $client->sendGetStateRequest($request);
    switch ($response->getStatus()) {
        case Payment::STATUS_CONFIRMED:
            
            break;

        case Payment::STATUS_CANCELED:
            // платеж был отменен
            break;
    }   
} catch (TinkoffAPIException $e) {
    // обработка ошибки
}
```

### Confirm

Метод подтверждает платеж и списывает ранее заблокированные средства.

```php
use JustCommunication\TinkoffAcquiringAPIClient\API\ConfirmRequest;
use JustCommunication\TinkoffAcquiringAPIClient\Exception\TinkoffAPIException;

$payment_id = '1234'; //Идентификатор платежа в системе банка
$request = new ConfirmRequest($payment_id);

try {
    $response = $client->sendConfirmRequest($request);
} catch (TinkoffAPIException $e) {
    // обработка ошибки
}
```

### Cancel

Метод отменяет платеж.

```php
use JustCommunication\TinkoffAcquiringAPIClient\API\CancelRequest;
use JustCommunication\TinkoffAcquiringAPIClient\Exception\TinkoffAPIException;

$payment_id = '1234'; //Идентификатор платежа в системе банка
$request = new CancelRequest($payment_id);

try {
    $response = $client->sendCancelRequest($request);
} catch (TinkoffAPIException $e) {
    // обработка ошибки
}
```

## Настройка HTTP клиента

### Способ №1: передача массива параметров

```php
use JustCommunication\TinkoffAcquiringAPIClient\TinkoffAcquiringAPIClient;

$client = new TinkoffAcquiringAPIClient('token', 'secret', [
    'proxy' => 'tcp://localhost:8125',
    'timeout' => 6,
    'connect_timeout' => 4
]);
```

Список доступных параметров: https://docs.guzzlephp.org/en/stable/request-options.html

### Способ №2: передача своего `\GuzzleHttp\Client`

Настройте своего http клиента:

```php
// Http клиент с логгированием всех запросов

$stack = HandlerStack::create();
$stack->push(Middleware::log($logger, new MessageFormatter(MessageFormatter::DEBUG)));

$httpClient = new \GuzzleHttp\Client([
    'handler' => $stack,
    'timeout' => 6
]);
```

и передайте его аргументом конструктора:

```php
use JustCommunication\TinkoffAcquiringAPIClient\TinkoffAcquiringAPIClient;

$client = new TinkoffAcquiringAPIClient('token', 'secret', $httpClient);
```

либо сеттером:

```php
use JustCommunication\TinkoffAcquiringAPIClient\TinkoffAcquiringAPIClient;

$client = new TinkoffAcquiringAPIClient('token', 'secret');
$client->setHttpClient($httpClient);
```

## Логирование

В `$client` можно передать свой `Psr\Logger`.

```php
$client->setLogger($someLogger);
```

По-умолчанию логирование отключено

## Тесты

Запустить тесты можно командой:

`vendor/bin/phpunit`