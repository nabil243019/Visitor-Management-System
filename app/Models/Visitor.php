<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'nama',
        'perusahaan',
        'no_hp',
        'email',
        'tujuan',
        'nomor_rak',
        'foto',
        'waktu_masuk',
        'waktu_keluar',
        'status'
    ];


    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime'
    ];
}