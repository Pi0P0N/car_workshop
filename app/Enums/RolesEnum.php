<?php

namespace App\Enums;

use Illuminate\Support\Facades\Auth;

enum RolesEnum: int
{
    case Customer = 0;
    case Employee = 1;

    case Manager = 2;

    public static function isCustomer(): bool
    {
        return match (Auth::user()->role) {
            self::Customer->value => true,
            default => false,
        };
    }

    public static function isEmployee(): bool
    {
        return match (Auth::user()->role) {
            self::Employee->value => true,
            default => false,
        };
    }

    public static function isManager(): bool
    {
        return match (Auth::user()->role) {
            self::Manager->value => true,
            default => false,
        };
    }

    public static function isWorkingHere(): bool
    {
        return self::isEmployee() || self::isManager();
    }

    public static function getAll()
    {
        return [
            self::Customer->value,
            self::Employee->value,
            self::Manager->value
        ];
    }

    public static function getLabel(int $role): string
    {
        return match ($role) {
            self::Customer->value => 'Klient',
            self::Employee->value => 'Pracownik',
            self::Manager->value => 'Manager',
            default => 'Unknown',
        };
    }
}