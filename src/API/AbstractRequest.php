<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

abstract class AbstractRequest implements RequestInterface
{
    const URI = null;
    const HTTP_METHOD = 'GET';
    const RESPONSE_CLASS = null;

    public function getUri()
    {
        return $this::URI;
    }

    public function getHttpMethod()
    {
        return $this::HTTP_METHOD;
    }

    public function getResponseClass()
    {
        return $this::RESPONSE_CLASS;
    }

    public function createHttpClientParams()
    {
        return [];
    }
}
