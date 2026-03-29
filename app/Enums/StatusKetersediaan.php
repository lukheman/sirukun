<?php

namespace App\Enums;

enum StatusKetersediaan: string
{
    case TERSEDIA = 'Tersedia';
    case DIHUNI = 'Dihuni';
    case RENOVASI = 'Renovasi';

    public function getLabel(): string
    {
        return match ($this) {
            self::TERSEDIA => 'Tersedia',
            self::DIHUNI => 'Dihuni',
            self::RENOVASI => 'Renovasi',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::TERSEDIA => 'success',
            self::DIHUNI => 'primary',
            self::RENOVASI => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::TERSEDIA => 'fas fa-check-circle',
            self::DIHUNI => 'fas fa-home',
            self::RENOVASI => 'fas fa-tools',
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
