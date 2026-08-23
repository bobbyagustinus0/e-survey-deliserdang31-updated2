<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SurveyTemplate;
use App\Models\UserIntegration;
use App\Services\SurveyResponseRecorder;
use Illuminate\Http\Request;

/**
 * INBOUND: website User -> kita.
 *
 * Publik (tidak pakai Sanctum Bearer Token), diverifikasi lewat header
 * `X-Webhook-Token` yang dibandingkan dengan hash yang tersimpan di
 * user_integrations.webhook_token_hash (lihat UserIntegration::findByWebhookToken).
 *
 * Endpoint & format payload didokumentasikan di docs/API_CONTRACT.md
 * bagian "Inbound - Webhook Jawaban Survei".
 */
class WebhookSurveyController extends Controller
{
    /**
     * POST /api/webhook/survey-jawaban
     * Header : X-Webhook-Token: <token>
     * body   : {
     *   "kode_survei": "SVY-001",
     *   "nama_responden": "Budi Santoso",
     *   "email": "budi@mail.com",
     *   "no_hp": "0812xxxxxxx",
     *   "data_tambahan": { "usia": "25", "pekerjaan": "Wiraswasta" },
     *   "jawaban": { "1": "4", "2": "3", "5": "Sangat mudah digunakan" }
     * }
     */
    public function store(Request $request, SurveyResponseRecorder $recorder)
    {
        $integration = UserIntegration::findByWebhookToken($request->header('X-Webhook-Token'));

        if (!$integration) {
            return response()->json([
                'success' => false,
                'message' => 'Webhook token tidak valid atau tidak dikenali.',
            ], 401);
        }

        $data = $request->validate([
            'kode_survei' => 'required|string',
            'nama_responden' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:150',
            'no_hp' => 'nullable|string|max:30',
            'data_tambahan' => 'nullable|array',
            'jawaban' => 'required|array|min:1',
        ]);

        // Survei harus milik User pemegang token webhook ini -- mencegah website A
        // mengirim jawaban atas nama survei milik website B.
        $surveyTemplate = SurveyTemplate::where('kode_survei', $data['kode_survei'])
            ->where('created_by', $integration->user_id)
            ->first();

        if (!$surveyTemplate) {
            return response()->json([
                'success' => false,
                'message' => 'Survei dengan kode tersebut tidak ditemukan / bukan milik akun ini.',
            ], 404);
        }

        if ($surveyTemplate->status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Survei ini sudah tidak aktif, jawaban ditolak.',
            ], 422);
        }

        $response = $recorder->record($surveyTemplate, [
            'user_id' => $integration->user_id,
            'nama_responden' => $data['nama_responden'] ?? null,
            'email' => $data['email'] ?? null,
            'no_hp' => $data['no_hp'] ?? null,
            'data_tambahan' => $data['data_tambahan'] ?? [],
            'jawaban' => $data['jawaban'],
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jawaban survei diterima.',
            'data' => [
                'response_id' => $response->id,
                'nilai_ikm' => $response->nilai_ikm,
                'kategori' => $response->kategoriMutu(),
            ],
        ], 201);
    }
}
