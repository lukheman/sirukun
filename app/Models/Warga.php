<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Warga extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'foto_ktp',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Get the warga's initials
     */
    public function initials(): string
    {
        return Str::of($this->nama)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function pengajuan(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'id_warga', 'id_warga');
    }
}
