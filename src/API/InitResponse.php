<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

/**
 * Class InitResponse
 *
 * @package JustCommunication\TinkoffAcquiringAPIClient\API
 */
class InitResponse extends AbstractResponse
{
    /**
     * Сумма в копейках
     *
     * @var int
     */
    protected $Amount;

    /**
     * Идентификатор заказа в системе продавца
     *
     * @var string
     */
    protected $OrderId;

    /**
     * Статус платежа
     *
     * @var string
     */
    protected $Status;

    /**
     * Идентификатор платежа в системе банка
     *
     * @var int
     */
    protected $PaymentId;

    /**
     * Ссылка на платежную форму
     *
     * @var string
     */
    protected $PaymentURL;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * @param int $Amount
     * @return InitResponse
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->OrderId;
    }

    /**
     * @param string $OrderId
     * @return InitResponse
     */
    public function setOrderId($OrderId)
    {
        $this->OrderId = $OrderId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     * @return InitResponse
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
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
     * @return InitResponse
     */
    public function setPaymentId($PaymentId)
    {
        $this->PaymentId = $PaymentId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentURL()
    {
        return $this->PaymentURL;
    }

    /**
     * @param string $PaymentURL
     * @return InitResponse
     */
    public function setPaymentURL($PaymentURL)
    {
        $this->PaymentURL = $PaymentURL;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function createFromResponseData(array $data)
    {
        $response = new InitResponse();
        $response
            ->setAmount($data['Amount'])
            ->setOrderId($data['OrderId'])
            ->setStatus($data['Status'])
            ->setPaymentId($data['PaymentId'])
            ->setPaymentURL($data['PaymentURL'])
        ;

        return $response;
    }
}