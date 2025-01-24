<?php

namespace App\Enums;

enum RepairStatusEnum: int
{
    case Pending = 0;
    case InProgress = 1;
    case Completed = 2;
    case Cancelled = 3;

    public static function fromValue(int $value): RepairStatusEnum
    {
        return match ($value) {
            0 => self::Pending,
            1 => self::InProgress,
            2 => self::Completed,
            3 => self::Cancelled,
        };
    }

    public static function getLabel(int $value): string
    {
        return match ($value) {
            0 => "Oczekujący",
            1 => "W trakcie",
            2 => "Zakończony",
            3 => "Anulowany"
        };
    }

    public static function getAll(): array
    {
        return [
            self::Pending,
            self::InProgress,
            self::Completed,
            self::Cancelled
        ];
    }
}