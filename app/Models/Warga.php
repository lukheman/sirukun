<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';
    protected $primaryKey = 'id_warga';

    protected $fillable = [
        'nik',
        'nkk',
        'nama',
        'alamat',
        'telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'password',
        'agama',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'password' => 'hashed',
    ];

    public function pengajuan(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'id_warga', 'id_warga');
    }
}
