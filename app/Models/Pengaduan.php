<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'dinas_pengaduan';

    // Tabel dari service Node.js ini tidak punya created_at/updated_at,
    // cuma kolom 'waktu'.
    public $timestamps = false;

    protected $fillable = [
        'id',
        'sumber_dinas',
        'nama',
        'kontak',
        'lokasi',
        'kategori',
        'isi',
        'status',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];
}
