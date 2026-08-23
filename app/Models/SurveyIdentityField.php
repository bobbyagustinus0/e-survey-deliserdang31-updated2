<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SurveyIdentityField extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_template_id', 'label', 'field_key', 'tipe', 'is_default', 'opsi_pilihan', 'urutan', 'wajib_diisi',
    ];

    protected $casts = [
        'opsi_pilihan' => 'array',
        'wajib_diisi' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(SurveyTemplate::class, 'survey_template_id');
    }

    public static function buatKeyUnik(string $label, int $surveyTemplateId, ?int $ignoreId = null): string
    {
        $base = Str::slug($label, '_');
        $key = $base;
        $i = 1;
        while (
            static::where('survey_template_id', $surveyTemplateId)
                ->where('field_key', $key)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $key = $base . '_' . (++$i);
        }
        return $key;
    }
}
