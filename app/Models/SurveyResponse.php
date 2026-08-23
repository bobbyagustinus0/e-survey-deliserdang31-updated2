<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_template_id', 'user_id', 'nama_responden', 'email', 'no_hp', 'jenis_kelamin',
        'usia', 'pekerjaan', 'data_tambahan', 'nilai_ikm', 'ip_address', 'tanggal_isi',
    ];

    protected $casts = [
        'tanggal_isi' => 'datetime',
        'data_tambahan' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(SurveyTemplate::class, 'survey_template_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class);
    }

    public function kategoriMutu(): string
    {
        $n = $this->nilai_ikm ?? 0;
        if ($n >= 88.31) return 'A (Sangat Baik)';
        if ($n >= 76.61) return 'B (Baik)';
        if ($n >= 65.00) return 'C (Kurang Baik)';
        return 'D (Tidak Baik)';
    }
}
