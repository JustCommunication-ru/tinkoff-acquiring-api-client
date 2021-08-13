<?php
namespace JustCommunication\TinkoffAcquiringAPIClient\Model;

class Payment
{
    const STATUS_NEW = 'NEW';
    const STATUS_FORM_SHOWED = 'FORM_SHOWED';
    const STATUS_DEADLINE_EXPIRED = 'DEADLINE_EXPIRED';
    const STATUS_CANCELED = 'CANCELED';
    const STATUS_PREAUTHORIZING = 'PREAUTHORIZING';
    const STATUS_AUTHORIZING = 'AUTHORIZING';
    const STATUS_AUTHORIZED = 'AUTHORIZED';
    const STATUS_AUTH_FAIL = 'AUTH_FAIL';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_DS_CHECKING = 'DS_CHECKING';
    const STATUS_DS_CHECKED = 'DS_CHECKED';
    const STATUS_REVERSING = 'REVERSING';
    const STATUS_PARTIAL_REVERSED = 'PARTIAL_REVERSED';
    const STATUS_REVERSED = 'REVERSED';
    const STATUS_CONFIRMING = 'CONFIRMING';
    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_REFUNDING = 'REFUNDING';
    const STATUS_PARTIAL_REFUNDED = 'PARTIAL_REFUNDED';
    const STATUS_REFUNDED = 'REFUNDED';
}