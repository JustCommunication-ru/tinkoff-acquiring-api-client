<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

/**
 * Class ConfirmRequest
 *
 * Метод подтверждает платеж и списывает ранее заблокированные средства.
 * Используется при двухстадийной оплате. При одностадийной оплате вызывается автоматически. Применим к платежу только в статусе AUTHORIZED и только один раз.
 * Сумма подтверждения не может быть больше заблокированной. Если сумма подтверждения меньше заблокированной, будет выполнено частичное подтверждение.
 *
 * @package JustCommunication\TinkoffAcquiringAPIClient\API
 */
class ConfirmRequest extends AbstractRequest
{
    const HTTP_METHOD = 'POST';
    const URI = 'Confirm';
    const RESPONSE_CLASS = ConfirmResponse::class;

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