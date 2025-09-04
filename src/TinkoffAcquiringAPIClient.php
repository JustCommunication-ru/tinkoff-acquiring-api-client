<?php
namespace JustCommunication\TinkoffAcquiringAPIClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JustCommunication\TinkoffAcquiringAPIClient\API\RequestInterface;
use JustCommunication\TinkoffAcquiringAPIClient\API\ResponseInterface;
use JustCommunication\TinkoffAcquiringAPIClient\Exception\TinkoffAPIException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

/**
 * @method API\InitResponse sendInitRequest(API\InitRequest $request)
 * @method API\GetStateResponse sendGetStateRequest(API\GetStateRequest $request)
 * @method API\ConfirmResponse sendConfirmRequest(API\ConfirmRequest $request)
 * @method API\CancelResponse sendCancelRequest(API\CancelRequest $request)
 */
class TinkoffAcquiringAPIClient implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const API_ENDPOINT = 'https://securepay.tinkoff.ru/v2/';

    protected static $default_http_client_options = [
        'connect_timeout' => 4,
        'timeout' => 10
    ];

    /**
     * @var string
     */
    protected $terminal_key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @param string $terminal_key
     * @param string $secret
     * @param Client|array|null $httpClientOrOptions
     */
    public function __construct($terminal_key, $secret, $httpClientOrOptions = null)
    {
        $this->terminal_key = $terminal_key;
        $this->secret = $secret;

        $this->logger = new NullLogger();
        $this->httpClient = self::createHttpClient($httpClientOrOptions);
    }

    public function getTerminalKey(): string
    {
        return $this->terminal_key;
    }

    public function setTerminalKey(string $terminal_key): self
    {
        $this->terminal_key = $terminal_key;
        return $this;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;
        return $this;
    }

    public function __call($name, array $arguments)
    {
        if (0 === \strpos($name, 'send')) {
            return call_user_func_array([ $this, 'sendRequest' ], $arguments);
        }

        throw new \BadMethodCallException(\sprintf('Method [%s] not found in [%s].', $name, __CLASS__));
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     *
     * @throws TinkoffAPIException
     */
    public function sendRequest(RequestInterface $request)
    {
        $this->logger->info('Tinkoff acquiring API request {http_method} {uri}', [
            'http_method' => $request->getHttpMethod(),
            'uri' => $request->getUri(),
            'request_params' => $request->createHttpClientParams()
        ]);

        /** @var Response $response */
        $response = $this->createAPIRequestPromise($request)->wait();

        $this->logger->info('Tinkoff acquiring API {http_method} {uri} response {response_code}', [
            'http_method' => $request->getHttpMethod(),
            'uri' => $request->getUri(),
            'response_code' => $response->getStatusCode(),
            'response' => (string)$response->getBody()
        ]);

        return $this->createAPIResponse($response, $request->getResponseClass());
    }

    /**
     * @param Response $response
     * @param string $apiResponseClass
     *
     * @return ResponseInterface
     *
     * @throws TinkoffAPIException
     */
    protected function createAPIResponse(Response $response, $apiResponseClass)
    {
        if (!is_a($apiResponseClass, ResponseInterface::class, true)) {
            throw new TinkoffAPIException('Invalid response class');
        }

        $response_string = (string)$response->getBody();

        $response_data = json_decode($response_string, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new TinkoffAPIException('Invalid response data');
        }

        if (isset($response_data['Success'])) {
            $is_success = $response_data['Success'];
            if (!$is_success) {
                $exception_message = $response_data['Message'];
                if (isset($response_data['Details'])) {
                    $exception_message .= ': ' . $response_data['Details'];
                }

                throw new TinkoffAPIException($exception_message, $response_data['ErrorCode']);
            }
        }

        return $apiResponseClass::createFromResponseData($response_data);
    }

    public function createAPIRequestPromise(RequestInterface $request)
    {
        $params = $request->createHttpClientParams();

        if (!isset($params['base_uri'])) {
            $params['base_uri'] = self::API_ENDPOINT;
        }

        if (!isset($params['json'])) {
            $params['json'] = [];
        }

        $params['json']['TerminalKey'] = $this->terminal_key;
        $params['json']['Token'] = $this->generateToken($params['json']);

        return $this->httpClient->requestAsync($request->getHttpMethod(), $request->getUri(), $params);
    }

    protected function generateToken(array $params)
    {
        foreach ([ 'Shops', 'Receipt', 'Data' ] as $ignore_key) {
            if (isset($params[$ignore_key])) {
                unset($params[$ignore_key]);
            }
        }

        $params['Password'] = $this->secret;
        ksort($params);

        $token = '';
        foreach ($params as $param_value) {
            if (is_scalar($param_value)) {
                $token .= $param_value;
            }
        }

        return hash('sha256', $token);
    }

    /**
     * @param Client $httpClient
     * @return $this
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param Client|array|null $httpClientOrOptions
     * @return Client
     */
    protected static function createHttpClient($httpClientOrOptions = null)
    {
        $httpClient = null;
        if ($httpClientOrOptions instanceof Client) {
            $httpClient = $httpClientOrOptions;
        } else if (is_array($httpClientOrOptions)) {
            $httpClient = new Client($httpClientOrOptions);
        } else {
            $httpClient = new Client(self::$default_http_client_options);
        }

        return $httpClient;
    }
}
