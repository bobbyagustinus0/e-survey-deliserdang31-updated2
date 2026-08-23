<?php

namespace App\Services;

use App\Models\SurveyTemplate;
use App\Models\UserIntegration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service OUTBOUND: kita -> website User.
 *
 * Dipanggil saat User mengaktifkan survei. Bertugas mengirim (push) data
 * survei ke `api_base_url` milik User, pakai `api_key` yang User isi sendiri
 * di menu Integrasi (kredensial dari sistem mereka, bukan dari kita).
 *
 * Endpoint tujuan di sisi website User: POST {api_base_url}/survey (lihat
 * docs/API_CONTRACT.md bagian "Outbound - Push Survei").
 */
class SurveyPushService
{
    private const TIMEOUT_DETIK = 15;

    /**
     * Test koneksi ke API website User (tombol "Test Koneksi" di menu Integrasi).
     * Tidak mengirim data survei apapun, cuma cek base URL + api_key valid.
     *
     * @return array{sukses: bool, pesan: string}
     */
    public function testConnection(UserIntegration $integration): array
    {
        if (!$integration->api_base_url || !$integration->api_key) {
            return ['sukses' => false, 'pesan' => 'API Base URL dan API Key harus diisi terlebih dahulu.'];
        }

        try {
            $response = $this->client($integration)->get($this->endpoint($integration, '/ping'));

            if ($response->successful()) {
                return ['sukses' => true, 'pesan' => 'Koneksi berhasil. Website merespons dengan status ' . $response->status() . '.'];
            }

            return ['sukses' => false, 'pesan' => 'Website merespons dengan status ' . $response->status() . ': ' . $this->ringkasBody($response->body())];
        } catch (\Throwable $e) {
            return ['sukses' => false, 'pesan' => 'Gagal terhubung: ' . $e->getMessage()];
        }
    }

    /**
     * Push 1 template survei (+ pertanyaan & field data diri) ke website User.
     * Dipanggil otomatis saat status survei diubah jadi "aktif".
     *
     * @return array{sukses: bool, pesan: string}
     */
    public function pushSurvey(SurveyTemplate $surveyTemplate): array
    {
        $integration = $surveyTemplate->creator?->integration;

        if (!$integration || !$integration->api_base_url || !$integration->api_key) {
            return [
                'sukses' => false,
                'pesan' => 'User pemilik survei ini belum mengatur Integrasi API (api_base_url / api_key).',
            ];
        }

        $payload = $this->buildPayload($surveyTemplate);

        try {
            $response = $this->client($integration)
                ->post($this->endpoint($integration, '/survey'), $payload);

            if ($response->successful()) {
                return ['sukses' => true, 'pesan' => 'Survei berhasil dikirim ke website User.'];
            }

            Log::warning('Push survei gagal', [
                'survey_template_id' => $surveyTemplate->id,
                'status' => $response->status(),
                'body' => $this->ringkasBody($response->body()),
            ]);

            return [
                'sukses' => false,
                'pesan' => 'Website menolak data (status ' . $response->status() . '): ' . $this->ringkasBody($response->body()),
            ];
        } catch (\Throwable $e) {
            Log::error('Push survei error', [
                'survey_template_id' => $surveyTemplate->id,
                'error' => $e->getMessage(),
            ]);

            return ['sukses' => false, 'pesan' => 'Gagal mengirim ke website User: ' . $e->getMessage()];
        }
    }

    /**
     * Bentuk payload sesuai format yang sudah distandarkan di API contract,
     * supaya semua developer eksternal implementasi "pintu penerima" yang sama persis.
     */
    private function buildPayload(SurveyTemplate $surveyTemplate): array
    {
        $surveyTemplate->loadMissing(['questions', 'identityFields']);

        return [
            'kode_survei' => $surveyTemplate->kode_survei,
            'judul_survei' => $surveyTemplate->judul_survei,
            'status' => $surveyTemplate->status,
            'unit_layanan' => $surveyTemplate->unit_layanan,
            'deskripsi' => $surveyTemplate->deskripsi,
            'tanggal_mulai' => optional($surveyTemplate->tanggal_mulai)->toDateString(),
            'tanggal_selesai' => optional($surveyTemplate->tanggal_selesai)->toDateString(),
            // Pengaturan pop up: kapan & seberapa sering pop up ditampilkan di website dinas.
            'popup' => [
                'tampil_setelah_detik' => (int) ($surveyTemplate->popup_tampil_setelah_detik ?? 3),
                'frekuensi' => $surveyTemplate->popup_frekuensi ?? 'sekali_per_sesi',
                'jam_mulai' => $surveyTemplate->popup_jam_mulai,
                'jam_selesai' => $surveyTemplate->popup_jam_selesai,
            ],
            'field_data_diri' => $surveyTemplate->identityFields->map(fn ($f) => [
                'field_key' => $f->field_key,
                'label' => $f->label,
                'tipe' => $f->tipe,
                'wajib_diisi' => (bool) $f->wajib_diisi,
                'opsi_pilihan' => $f->opsi_pilihan,
            ])->values(),
            'pertanyaan' => $surveyTemplate->questions->map(fn ($q) => [
                'id' => $q->id,
                'kategori' => $q->kategori,
                'pertanyaan' => $q->pertanyaan,
                'tipe_jawaban' => $q->tipe_jawaban,
                'opsi_jawaban' => $q->opsi_jawaban,
                'wajib_diisi' => (bool) $q->wajib_diisi,
                'urutan' => $q->urutan,
            ])->values(),
        ];
    }

    private function client(UserIntegration $integration)
    {
        return Http::withToken($integration->api_key)
            ->timeout(self::TIMEOUT_DETIK)
            ->acceptJson();
    }

    private function endpoint(UserIntegration $integration, string $path): string
    {
        return rtrim($integration->api_base_url, '/') . '/' . ltrim($path, '/');
    }

    private function ringkasBody(string $body): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($body), 200);
    }
}
