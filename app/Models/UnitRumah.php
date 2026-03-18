<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function penempatan(): HasOne
    {
        return $this->hasOne(Penempatan::class, 'id_unit', 'id_unit');
    }
}
