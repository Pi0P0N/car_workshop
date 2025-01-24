<?php

namespace App\Enums;

enum PaymentStatusEnum: int
{
    case Pending = 0;
    case Paid = 1;
    case Failed = 2;
    case Refunded = 3;

    public static function fromValue(int $value): PaymentStatusEnum
    {
        return match ($value) {
            0 => self::Pending,
            1 => self::Paid,
            2 => self::Failed,
            3 => self::Refunded,
        };
    }
}