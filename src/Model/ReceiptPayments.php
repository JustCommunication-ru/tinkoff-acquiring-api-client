<?php

namespace JustCommunication\TinkoffAcquiringAPIClient\Model;

use JsonSerializable;

class ReceiptPayments implements JsonSerializable
{
    protected ?int $Cash = null;
    protected ?int $Electronic = null;
    protected ?int $AdvancePayment = null;
    protected ?int $Credit = null;
    protected ?int $Provision = null;

    public function getCash(): ?int
    {
        return $this->Cash;
    }

    public function setCash(?int $Cash): self
    {
        $this->Cash = $Cash;
        return $this;
    }

    public function getElectronic(): ?int
    {
        return $this->Electronic;
    }

    public function setElectronic(?int $Electronic): self
    {
        $this->Electronic = $Electronic;
        return $this;
    }

    public function getAdvancePayment(): ?int
    {
        return $this->AdvancePayment;
    }

    public function setAdvancePayment(?int $AdvancePayment): self
    {
        $this->AdvancePayment = $AdvancePayment;
        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->Credit;
    }

    public function setCredit(?int $Credit): self
    {
        $this->Credit = $Credit;
        return $this;
    }

    public function getProvision(): ?int
    {
        return $this->Provision;
    }

    public function setProvision(?int $Provision): self
    {
        $this->Provision = $Provision;
        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = [];

        if ($this->Cash) {
            $data['Cash'] = $this->Cash;
        }

        if ($this->Electronic) {
            $data['Electronic'] = $this->Electronic;
        }

        if ($this->AdvancePayment) {
            $data['AdvancePayment'] = $this->AdvancePayment;
        }

        if ($this->Credit) {
            $data['Credit'] = $this->Credit;
        }

        if ($this->Provision) {
            $data['Provision'] = $this->Provision;
        }

        return $data;
    }
}
