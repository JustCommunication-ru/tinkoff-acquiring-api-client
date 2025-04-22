<?php

namespace JustCommunication\TinkoffAcquiringAPIClient\Model;

use JsonSerializable;

class ReceiptItemFFD12 implements JsonSerializable
{
    protected string $name;
    protected int $price;
    protected int $quantity;
    protected string $tax;
    protected ?string $paymentMethod;
    protected ?string $paymentObject;
    protected ?string $ean13;
    protected ?string $shopCode;

    public function __construct(string $name, int $price, int $quantity, string $tax, ?string $paymentMethod = null, ?string $paymentObject = null, ?string $ean13 = null, ?string $shopCode = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->tax = $tax;
        $this->paymentMethod = $paymentMethod;
        $this->paymentObject = $paymentObject;
        $this->ean13 = $ean13;
        $this->shopCode = $shopCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getTax(): string
    {
        return $this->tax;
    }

    public function setTax(string $tax): self
    {
        $this->tax = $tax;
        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function getPaymentObject(): ?string
    {
        return $this->paymentObject;
    }

    public function setPaymentObject(?string $paymentObject): self
    {
        $this->paymentObject = $paymentObject;
        return $this;
    }

    public function getEan13(): ?string
    {
        return $this->ean13;
    }

    public function setEan13(?string $ean13): self
    {
        $this->ean13 = $ean13;
        return $this;
    }

    public function getShopCode(): ?string
    {
        return $this->shopCode;
    }

    public function setShopCode(?string $shopCode): self
    {
        $this->shopCode = $shopCode;
        return $this;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = [
            'Name' => $this->name,
            'Price' => $this->price,
            'Quantity' => $this->quantity,
            'Amount' => $this->price * $this->quantity,
            'Tax' => $this->tax
        ];

        if ($this->paymentMethod) {
            $data['PaymentMethod'] = $this->paymentMethod;
        }

        if ($this->paymentObject) {
            $data['PaymentObject'] = $this->paymentObject;
        }

        if ($this->ean13) {
            $data['Ean13'] = $this->ean13;
        }

        if ($this->shopCode) {
            $data['ShopCode'] = $this->shopCode;
        }

        return $data;
    }
}
