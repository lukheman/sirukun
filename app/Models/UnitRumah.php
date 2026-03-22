<?php

namespace App\Models;

use App\Enums\StatusKetersediaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UnitRumah extends Model
{
    use HasFactory;

    protected $table = 'unit_rumah';

    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'blok',
        'nomor',
        'status_ketersediaan',
    ];

    protected $casts = [
        'status_ketersediaan' => StatusKetersediaan::class,
    ];

    /**
     * Semua riwayat penempatan (termasuk yang sudah keluar).
     */
    public function penempatans(): HasMany
    {
        return $this->hasMany(Penempatan::class, 'id_unit', 'id_unit');
    }

    /**
     * Penempatan aktif saat ini (backward compat).
     */
    public function penempatan(): HasOne
    {
        return $this->hasOne(Penempatan::class, 'id_unit', 'id_unit')
            ->whereNull('tanggal_keluar');
    }
}
