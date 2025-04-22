<?php

namespace JustCommunication\TinkoffAcquiringAPIClient\Model;

use DateTime;
use JsonSerializable;

class ReceiptFFD12ClientInfo implements JsonSerializable
{
    protected ?DateTime $Birthdate = null;
    protected ?string $Citizenship = null;
    protected ?string $DocumentCode = null;
    protected ?string $DocumentData = null;
    protected ?string $Address = null;

    public function getBirthdate(): ?DateTime
    {
        return $this->Birthdate;
    }

    public function setBirthdate(?DateTime $Birthdate): self
    {
        $this->Birthdate = $Birthdate;
        return $this;
    }

    public function getCitizenship(): ?string
    {
        return $this->Citizenship;
    }

    public function setCitizenship(?string $Citizenship): self
    {
        $this->Citizenship = $Citizenship;
        return $this;
    }

    public function getDocumentCode(): ?string
    {
        return $this->DocumentCode;
    }

    public function setDocumentCode(?string $DocumentCode): self
    {
        $this->DocumentCode = $DocumentCode;
        return $this;
    }

    public function getDocumentData(): ?string
    {
        return $this->DocumentData;
    }

    public function setDocumentData(?string $DocumentData): self
    {
        $this->DocumentData = $DocumentData;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): self
    {
        $this->Address = $Address;
        return $this;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = [];

        if ($this->Birthdate) {
            $data['Birthdate'] = $this->Birthdate->format('d.m.Y');
        }

        if ($this->Citizenship) {
            $data['Citizenship'] = $this->Citizenship;
        }

        if ($this->DocumentCode) {
            $data['DocumentCode'] = $this->DocumentCode;
        }

        if ($this->DocumentData) {
            $data['DocumentData'] = $this->DocumentData;
        }

        if ($this->Address) {
            $data['Address'] = $this->Address;
        }

        return $data;
    }
}
