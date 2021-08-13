<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

/**
 * Class ConfirmResponse
 *
 * @package JustCommunication\TinkoffAcquiringAPIClient\API
 */
class ConfirmResponse extends AbstractResponse
{
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
     * @return string
     */
    public function getOrderId()
    {
        return $this->OrderId;
    }

    /**
     * @param string $OrderId
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setPaymentId($PaymentId)
    {
        $this->PaymentId = $PaymentId;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function createFromResponseData(array $data)
    {
        $response = new GetStateResponse();
        $response
            ->setOrderId($data['OrderId'])
            ->setStatus($data['Status'])
            ->setPaymentId($data['PaymentId'])
        ;

        return $response;
    }
}