<?php

namespace App\Enums;

enum JenisPengajuan: string
{
    case MASUK = 'Masuk';
    case KELUAR = 'Keluar';

    public function getLabel(): string
    {
        return match ($this) {
            self::MASUK => 'Masuk',
            self::KELUAR => 'Keluar',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::MASUK => 'success',
            self::KELUAR => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::MASUK => 'fas fa-sign-in-alt',
            self::KELUAR => 'fas fa-sign-out-alt',
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
