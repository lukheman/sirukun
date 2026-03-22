<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class KepalaDinas extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'kepala_dinas';

    protected $primaryKey = 'id_kepala_dinas';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Get the kepala dinas' initials
     */
    public function initials(): string
    {
        $words = explode(' ', $this->nama);
        if (count($words) >= 2) {
            return Str::upper(Str::substr($words[0], 0, 1) . Str::substr($words[1], 0, 1));
        }
        return Str::upper(Str::substr($this->nama, 0, 2));
    }
}
