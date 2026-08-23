<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_survei', 'judul_survei', 'unit_layanan', 'deskripsi',
        'tanggal_mulai', 'tanggal_selesai', 'status', 'created_by',
        'popup_tampil_setelah_detik', 'popup_frekuensi', 'popup_jam_mulai', 'popup_jam_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'popup_tampil_setelah_detik' => 'integer',
    ];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class)->orderBy('urutan');
    }

    public function identityFields()
    {
        return $this->hasMany(SurveyIdentityField::class)->orderBy('urutan');
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
