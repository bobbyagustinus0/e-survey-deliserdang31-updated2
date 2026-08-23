<?php

namespace App\Services;

use App\Models\SurveyAnswer;
use App\Models\SurveyResponse;
use App\Models\SurveyTemplate;

/**
 * Menyimpan 1 jawaban survei + menghitung nilai IKM-nya.
 * Logika ini sama persis dengan yang dipakai app mobile (SurveyApiController::submit),
 * dipisah ke sini supaya webhook inbound dari website User pakai perhitungan yang sama.
 */
class SurveyResponseRecorder
{
    /**
     * @param array $payload {
     *     nama_responden?: string, email?: string, no_hp?: string,
     *     data_tambahan?: array, jawaban: array<int,mixed> (question_id => jawaban),
     *     ip_address?: string, user_id?: int|null
     * }
     */
    public function record(SurveyTemplate $surveyTemplate, array $payload): SurveyResponse
    {
        $response = SurveyResponse::create([
            'survey_template_id' => $surveyTemplate->id,
            'user_id' => $payload['user_id'] ?? null,
            'nama_responden' => $payload['nama_responden'] ?? null,
            'email' => $payload['email'] ?? null,
            'no_hp' => $payload['no_hp'] ?? null,
            'data_tambahan' => $payload['data_tambahan'] ?? [],
            'ip_address' => $payload['ip_address'] ?? null,
            'tanggal_isi' => now(),
        ]);

        $totalPersen = 0;
        $countTerukur = 0;

        foreach ($payload['jawaban'] ?? [] as $questionId => $jawaban) {
            $question = $surveyTemplate->questions()->find($questionId);
            if (!$question) {
                continue;
            }

            $nilaiSkala = null;
            $maksimalSkala = null;

            if ($question->tipe_jawaban === 'skala_ikm' && is_numeric($jawaban)) {
                $nilaiSkala = (int) $jawaban;
                $maksimalSkala = 4;
            } elseif ($question->tipe_jawaban === 'rating_bintang' && is_numeric($jawaban)) {
                $nilaiSkala = (int) $jawaban;
                $maksimalSkala = 5;
            }

            if ($maksimalSkala) {
                $totalPersen += ($nilaiSkala / $maksimalSkala) * 100;
                $countTerukur++;
            }

            SurveyAnswer::create([
                'survey_response_id' => $response->id,
                'survey_question_id' => $questionId,
                'jawaban' => is_array($jawaban) ? implode(', ', $jawaban) : $jawaban,
                'nilai_skala' => $nilaiSkala,
            ]);
        }

        if ($countTerukur > 0) {
            $response->update(['nilai_ikm' => round($totalPersen / $countTerukur, 2)]);
        }

        return $response;
    }
}
