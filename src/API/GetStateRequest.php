<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

/**
 * Class GetStateRequest
 *
 * Метод возвращает текущий статус платежа.
 *
 * @package JustCommunication\TinkoffAcquiringAPIClient\API
 */
class GetStateRequest extends AbstractRequest
{
    const HTTP_METHOD = 'POST';
    const URI = 'GetState';
    const RESPONSE_CLASS = GetStateResponse::class;

    /**
     * Идентификатор платежа в системе банка
     *
     * @var int
     */
    protected $PaymentId;

    /**
     * IP-адрес покупателя
     *
     * @var string
     */
    protected $IP;

    /**
     * ConfirmRequest constructor.
     *
     * @param int $PaymentId
     */
    public function __construct($PaymentId)
    {
        $this->PaymentId = $PaymentId;
    }

    /**
     * @return int
     */
    public function getPaymentId()
    {
        return $this->PaymentId;
    }

    /**
     * @param int $PaymentId
     * @return GetStateRequest
     */
    public function setPaymentId($PaymentId)
    {
        $this->PaymentId = $PaymentId;
        return $this;
    }

    /**
     * @return string
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * @param string $IP
     * @return GetStateRequest
     */
    public function setIP($IP)
    {
        $this->IP = $IP;
        return $this;
    }

    public function createHttpClientParams()
    {
        $params = [
            'PaymentId' => $this->PaymentId
        ];

        if ($this->IP) {
            $params['IP'] = $this->IP;
        }

        return [
            'json' => $params
        ];
    }
}