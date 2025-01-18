<?php

namespace App\Interfaces;

interface PaymentStatusInterface
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETE = 'complete';
    public const STATUS_CANCEL = 'cancel';
}