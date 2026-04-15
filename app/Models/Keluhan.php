<?php

namespace App\Models;

use App\Enums\StatusKeluhan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keluhan extends Model
{
    use HasFactory;

    protected $table = 'keluhan';

    protected $primaryKey = 'id_keluhan';

    protected $fillable = [
        'id_warga',
        'judul',
        'isi',
        'status',
        'balasan',
        'dibalas_pada',
    ];

    protected $casts = [
        'status'       => StatusKeluhan::class,
        'dibalas_pada' => 'datetime',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'id_warga', 'id_warga');
    }
}
