<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\Exception;

class TinkoffAPIException extends \Exception
{
    /**
     * @var string|int
     */
    protected $error_code;

    public function __construct($message, $error_code = null)
    {
        $this->error_code = $error_code;
        parent::__construct($message);
    }

    /**
     * @param int|string $error_code
     * @return $this
     */
    public function setErrorCode($error_code)
    {
        $this->error_code = $error_code;
        return $this;
    }

    /**
     * @return int|string
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }
}