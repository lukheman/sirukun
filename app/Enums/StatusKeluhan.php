<?php

namespace App\Enums;

enum StatusKeluhan: string
{
    case MENUNGGU = 'Menunggu';
    case DIPROSES = 'Diproses';
    case SELESAI = 'Selesai';

    public function getLabel(): string
    {
        return match ($this) {
            self::MENUNGGU => 'Menunggu',
            self::DIPROSES => 'Diproses',
            self::SELESAI  => 'Selesai',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::MENUNGGU => 'warning',
            self::DIPROSES => 'info',
            self::SELESAI  => 'success',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::MENUNGGU => 'fas fa-clock',
            self::DIPROSES => 'fas fa-spinner',
            self::SELESAI  => 'fas fa-check-circle',
        };
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
