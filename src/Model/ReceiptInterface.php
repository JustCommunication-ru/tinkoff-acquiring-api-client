<?php

namespace JustCommunication\TinkoffAcquiringAPIClient\Model;

use JsonSerializable;

interface ReceiptInterface extends JsonSerializable
{
    const TAXATION_OSN = 'osn';
    const TAXATION_USN_INCOME = 'usn_income';
    const TAXATION_USN_INCOME_OUTCOME = 'usn_income_outcome';
    const TAXATION_ENVD = 'envd';
    const TAXATION_ESN = 'esn';
    const TAXATION_PATENT = 'patent';
}