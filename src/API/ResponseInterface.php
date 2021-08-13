<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

use JustCommunication\TinkoffAcquiringAPIClient\Exception\TinkoffAPIException;

interface ResponseInterface
{
    /**
     * @param array $data
     *
     * @throws TinkoffAPIException
     * @return ResponseInterface
     */
    public static function createFromResponseData(Array $data);
}
