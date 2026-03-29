<?php

namespace App\Enums;

enum StatusPengajuan: string
{
    case MENUNGGU = 'Menunggu';
    case DISETUJUI = 'Disetujui';
    case DITOLAK = 'Ditolak';

    public function getLabel(): string
    {
        return match ($this) {
            self::MENUNGGU => 'Menunggu',
            self::DISETUJUI => 'Disetujui',
            self::DITOLAK => 'Ditolak',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::MENUNGGU => 'warning',
            self::DISETUJUI => 'success',
            self::DITOLAK => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::MENUNGGU => 'fas fa-clock',
            self::DISETUJUI => 'fas fa-check-circle',
            self::DITOLAK => 'fas fa-times-circle',
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
