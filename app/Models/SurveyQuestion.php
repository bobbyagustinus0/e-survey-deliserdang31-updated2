<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_template_id', 'kategori', 'pertanyaan', 'tipe_jawaban', 'opsi_jawaban', 'urutan', 'wajib_diisi',
    ];

    protected $casts = [
        'opsi_jawaban' => 'array',
        'wajib_diisi' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(SurveyTemplate::class, 'survey_template_id');
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_question_id');
    }
}