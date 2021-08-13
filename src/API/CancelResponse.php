<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

/**
 * Class CancelResponse
 *
 * @package JustCommunication\TinkoffAcquiringAPIClient\API
 */
class CancelResponse extends AbstractResponse
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
     * @var int
     */
    protected $OriginalAmount;

    /**
     * @var int
     */
    protected $NewAmount;

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
     * @return int
     */
    public function getOriginalAmount()
    {
        return $this->OriginalAmount;
    }

    /**
     * @param int $OriginalAmount
     * @return $this
     */
    public function setOriginalAmount($OriginalAmount)
    {
        $this->OriginalAmount = $OriginalAmount;
        return $this;
    }

    /**
     * @return int
     */
    public function getNewAmount()
    {
        return $this->NewAmount;
    }

    /**
     * @param int $NewAmount
     * @return $this
     */
    public function setNewAmount($NewAmount)
    {
        $this->NewAmount = $NewAmount;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function createFromResponseData(array $data)
    {
        $response = new CancelResponse();
        $response
            ->setOrderId($data['OrderId'])
            ->setStatus($data['Status'])
            ->setPaymentId($data['PaymentId'])
            ->setOriginalAmount($data['OriginalAmount'])
            ->setNewAmount($data['NewAmount'])
        ;

        return $response;
    }
}