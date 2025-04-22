<?php

namespace JustCommunication\TinkoffAcquiringAPIClient\Model;

class ReceiptFFD105 implements ReceiptInterface
{
    protected ?string $Email = null;
    protected ?string $Phone = null;
    protected ?string $Taxation = null;
    protected ?ReceiptPayments $Payments = null;

    /**
     * @var ReceiptItemFFD105[]
     */
    protected array $Items;

    public function __construct(?string $Email = null, ?string $Phone = null, ?string $Taxation = null, array $Items = [])
    {
        $this->Email = $Email;
        $this->Phone = $Phone;
        $this->Taxation = $Taxation;
        $this->Items = $Items;
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
        return $this->Items;
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

    public function setItems(array $Items): self
    {
        $this->Items = $Items;
        return $this;
    }

    public function addItem(ReceiptItemFFD105 $Item): self
    {
        $this->Items[] = $Item;
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

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = [
            'FfdVersion' => '1.05',
            'Items' => $this->Items,
            'Email' => $this->Email,
            'Phone' => $this->Phone,
            'Taxation' => $this->Taxation,
        ];

        if ($this->Payments) {
            $data['Payments'] = $this->Payments;
        }

        return $data;
    }
}
