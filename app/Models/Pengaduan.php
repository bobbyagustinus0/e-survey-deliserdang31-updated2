<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel `dinas_pengaduan`.
 *
 * PENTING: tabel ini TIDAK dibuat/dikelola oleh migration Laravel. Tabel
 * ini dibuat otomatis oleh backend Node.js masing-masing dinas (mis. Damkar
 * Deli Serdang) lewat fungsi ensureTables() di db-survey-mysql.js, pada
 * database MySQL yang SAMA dengan E-Survey (lihat DB_DATABASE di .env,
 * harus sama persis dengan punya Damkar).
 *
 * Alurnya:
 * 1. Warga isi form "Lapor" di website Dinas.
 * 2. Backend Node.js dinas tsb INSERT langsung ke tabel dinas_pengaduan
 *    (fungsi simpanPengaduan()).
 * 3. Laravel (di sini) tinggal membaca tabel yang sama lewat model ini —
 *    tidak ada webhook/API call, murni baca tabel database bersama.
 */
class Pengaduan extends Model
{
    protected $table = 'dinas_pengaduan';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id', 'sumber_dinas', 'nama', 'kontak', 'lokasi', 'kategori', 'isi', 'status', 'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];
}
