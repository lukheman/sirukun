<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penempatan extends Model
{
    use HasFactory;

    protected $table = 'penempatan';

    protected $primaryKey = 'id_penempatan';

    protected $fillable = [
        'id_pengajuan',
        'id_unit',
        'tanggal_masuk',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function unitRumah(): BelongsTo
    {
        return $this->belongsTo(UnitRumah::class, 'id_unit', 'id_unit');
    }
}
