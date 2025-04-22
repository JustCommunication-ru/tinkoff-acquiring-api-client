<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\API;

use JustCommunication\TinkoffAcquiringAPIClient\Model\ReceiptInterface;

/**
 * Class InitRequest
 *
 * Метод создает платеж: продавец получает ссылку на платежную форму и должен перенаправить по ней покупателя
 *
 * @package JustCommunication\TinkoffAcquiringAPIClient\API
 */
class InitRequest extends AbstractRequest
{
    const HTTP_METHOD = 'POST';
    const URI = 'Init';
    const RESPONSE_CLASS = InitResponse::class;

    const LANGUAGE_RU = 'ru';
    const LANGUAGE_EN = 'en';

    const PAY_TYPE_ONE_STAGE = 'O';
    const PAY_TYPE_TWO_STAGE = 'T';

    /**
     * Идентификатор заказа в системе продавца
     *
     * @var string
     */
    protected $OrderId;

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
     * Описание заказа
     *
     * @var string
     */
    protected $Description;

    /**
     * Язык платежной формы:
     * ru — русский
     * en — английский
     *
     * @var string
     */
    protected $Language;

    /**
     * Идентификатор родительского платежа
     * Передается со значением Y
     *
     * @var string
     */
    protected $Recurrent;

    /**
     * Идентификатор покупателя в системе продавца. Передается вместе с параметром CardId. См. метод GetGardList
     * Также необходим для сохранения карт на платежной форме (платежи в один клик).
     *
     * @var string
     */
    protected $CustomerKey;

    /**
     * @var \DateTime|null
     */
    protected $RedirectDueDate;

    /**
     * Адрес для получения http нотификаций
     *
     * @var string
     */
    protected $NotificationURL;

    /**
     * Страница успеха
     *
     * @var string
     */
    protected $SuccessURL;

    /**
     * Страница ошибки
     *
     * @var string
     */
    protected $FailURL;

    /**
     * Тип оплаты
     *
     * @var string
     */
    protected $PayType;

    /**
     * Дополнительные параметры платежа в формате "ключ":"значение" (не более 20 пар).
     * Наименование самого параметра должно быть в верхнем регистре, иначе его содержимое будет игнорироваться.
     *
     * @var array
     */
    protected $data = [];

    protected ?ReceiptInterface $receipt = null;

    /**
     * InitRequest constructor.
     *
     * @param int $Amount сумма в копейках
     * @param string $OrderId идентификатор заказа в системе продавца
     */
    public function __construct($Amount, $OrderId)
    {
        $this->Amount = $Amount;
        $this->OrderId = $OrderId;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->OrderId;
    }

    /**
     * @param string $OrderId идентификатор заказа в системе продавца
     * @return InitRequest
     */
    public function setOrderId($OrderId)
    {
        $this->OrderId = $OrderId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * @param int $Amount сумма в копейках
     * @return InitRequest
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
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
     * @return InitRequest
     */
    public function setIP($IP)
    {
        $this->IP = $IP;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param string $Description
     * @return InitRequest
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->Language;
    }

    /**
     * @param string $Language
     * @return InitRequest
     */
    public function setLanguage($Language)
    {
        if (!in_array($Language, [ self::LANGUAGE_RU, self::LANGUAGE_EN ])) {
            $Language = null;
        }

        $this->Language = $Language;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecurrent()
    {
        return $this->Recurrent;
    }

    /**
     * @param string $Recurrent
     * @return InitRequest
     */
    public function setRecurrent($Recurrent)
    {
        $this->Recurrent = $Recurrent;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerKey()
    {
        return $this->CustomerKey;
    }

    /**
     * @param string $CustomerKey
     * @return InitRequest
     */
    public function setCustomerKey($CustomerKey)
    {
        $this->CustomerKey = $CustomerKey;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getRedirectDueDate()
    {
        return $this->RedirectDueDate;
    }

    /**
     * @param \DateTime|null $RedirectDueDate
     * @return InitRequest
     */
    public function setRedirectDueDate($RedirectDueDate)
    {
        $this->RedirectDueDate = $RedirectDueDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotificationURL()
    {
        return $this->NotificationURL;
    }

    /**
     * @param string $NotificationURL
     * @return InitRequest
     */
    public function setNotificationURL($NotificationURL)
    {
        $this->NotificationURL = $NotificationURL;
        return $this;
    }

    /**
     * @return string
     */
    public function getSuccessURL()
    {
        return $this->SuccessURL;
    }

    /**
     * @param string $SuccessURL
     * @return InitRequest
     */
    public function setSuccessURL($SuccessURL)
    {
        $this->SuccessURL = $SuccessURL;
        return $this;
    }

    /**
     * @return string
     */
    public function getFailURL()
    {
        return $this->FailURL;
    }

    /**
     * @param string $FailURL
     * @return InitRequest
     */
    public function setFailURL($FailURL)
    {
        $this->FailURL = $FailURL;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayType()
    {
        return $this->PayType;
    }

    /**
     * @param string $PayType
     * @return InitRequest
     */
    public function setPayType($PayType)
    {
        if (!in_array($PayType, [ self::PAY_TYPE_ONE_STAGE, self::PAY_TYPE_TWO_STAGE ])) {
            $PayType = null;
        }

        $this->PayType = $PayType;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return InitRequest
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->data[$key] = (string)$value;
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function removeData($key)
    {
        if (array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
        }

        return $this;
    }

    public function getReceipt(): ?ReceiptInterface
    {
        return $this->receipt;
    }

    public function setReceipt(?ReceiptInterface $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function createHttpClientParams()
    {
        $params = [
            'Amount' => $this->Amount,
            'OrderId' => $this->OrderId
        ];

        if ($this->IP) {
            $params['IP'] = $this->IP;
        }

        if ($this->Description) {
            $params['Description'] = $this->Description;
        }

        if ($this->Language) {
            $params['Language'] = $this->Language;
        }

        if ($this->Recurrent) {
            $params['Recurrent'] = $this->Recurrent;
        }

        if ($this->CustomerKey) {
            $params['CustomerKey'] = $this->CustomerKey;
        }

        if ($this->RedirectDueDate) {
            $params['RedirectDueDate'] = $this->RedirectDueDate->format(\DateTime::ISO8601);
        }

        if ($this->NotificationURL) {
            $params['NotificationURL'] = $this->NotificationURL;
        }

        if ($this->SuccessURL) {
            $params['SuccessURL'] = $this->SuccessURL;
        }

        if ($this->FailURL) {
            $params['FailURL'] = $this->FailURL;
        }

        if ($this->PayType) {
            $params['PayType'] = $this->PayType;
        }

        if ($this->data) {
            $params['DATA'] = $this->data;
        }

        if ($this->receipt) {
            $params['Receipt'] = $this->receipt;
        }

        return [
            'json' => $params
        ];
    }
}