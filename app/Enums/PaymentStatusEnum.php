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
    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::Pending->value => 'Oczekująca',
            self::Paid->value => 'Opłacona',
            self::Failed->value => 'Nieudana',
            self::Refunded->value => 'Zwrócona',
            default => 'Nieznany',
        };
    }

    public static function getAllWithLabels(): array
    {
        return [
            self::Pending->value => self::getLabel(self::Pending->value),
            self::Paid->value => self::getLabel(self::Paid->value),
            self::Failed->value => self::getLabel(self::Failed->value),
            self::Refunded->value => self::getLabel(self::Refunded->value),
        ];
    }
}