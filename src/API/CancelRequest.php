<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

/**
 * Class CancelRequest
 *
 * Метод отменяет платеж.
 *
 * @package JustCommunication\TinkoffAcquiringAPIClient\API
 */
class CancelRequest extends AbstractRequest
{
    const HTTP_METHOD = 'POST';
    const URI = 'Cancel';
    const RESPONSE_CLASS = CancelResponse::class;

    /**
     * Идентификатор платежа в системе банка
     *
     * @var int
     */
    protected $PaymentId;

    /**
     * Сумма в копейках
     *
     * @var int
     */
    protected $Amount;

    /**
     * IP-адрес покупателя
     *
     * @var string
     */
    protected $IP;

    /**
     * CancelRequest constructor.
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
     * @return $this
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
     * @return $this
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

        if ($this->Amount) {
            $params['Amount'] = $this->Amount;
        }

        if ($this->IP) {
            $params['IP'] = $this->IP;
        }

        return [
            'json' => $params
        ];
    }
}