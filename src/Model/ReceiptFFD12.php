<?php

namespace JustCommunication\TinkoffAcquiringAPIClient\Model;

class ReceiptFFD12 implements ReceiptInterface
{
    protected ?string $Email = null;
    protected ?string $Phone = null;
    protected ?string $Taxation = null;
    protected ?ReceiptPayments $Payments = null;
    protected ?ReceiptFFD12ClientInfo $ClientInfo = null;

    /**
     * @var ReceiptItemFFD12[]
     */
    protected array $items;

    public function __construct(?string $email = null, ?string $phone = null, ?string $taxation = null, array $items = [])
    {
        $this->Email = $email;
        $this->Phone = $phone;
        $this->Taxation = $taxation;
        $this->items = $items;
    }

    public function getTaxation(): ?string
    {
        return $this->Taxation;
    }

    public function setTaxation(?string $Taxation): self
    {
        $this->Taxation = $Taxation;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(?string $Phone): self
    {
        $this->Phone = $Phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;
        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function addItem(ReceiptItemFFD12 $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    public function getPayments(): ?ReceiptPayments
    {
        return $this->Payments;
    }

    public function setPayments(?ReceiptPayments $Payments): self
    {
        $this->Payments = $Payments;
        return $this;
    }

    public function getClientInfo(): ?ReceiptFFD12ClientInfo
    {
        return $this->ClientInfo;
    }

    public function setClientInfo(?ReceiptFFD12ClientInfo $ClientInfo): self
    {
        $this->ClientInfo = $ClientInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = [
            'FfdVersion' => '1.2',
            'Items' => $this->items,
            'Email' => $this->Email,
            'Phone' => $this->Phone,
            'Taxation' => $this->Taxation,
        ];

        if ($this->Payments) {
            $data['Payments'] = $this->Payments;
        }

        if ($this->ClientInfo) {
            $data['ClientInfo'] = $this->ClientInfo;
        }

        return $data;
    }
}
