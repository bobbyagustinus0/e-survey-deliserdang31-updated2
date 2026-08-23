<?php

namespace App\Http\Controllers;

use App\Models\UserIntegration;
use App\Services\SurveyPushService;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    /**
     * Halaman "Integrasi" -> User isi api_base_url + api_key website mereka,
     * dan lihat/generate webhook_token yang harus dipasang di sisi website mereka.
     */
    public function index(Request $request)
    {
        $integration = $request->user()->integration ?? new UserIntegration();

        // Token webhook plaintext cuma ada di session sesaat setelah digenerate
        // (lihat regenerateWebhookToken), supaya bisa ditampilkan 1x lalu hilang.
        $webhookTokenBaru = session('webhook_token_baru');

        return view('integrations.index', compact('integration', 'webhookTokenBaru'));
    }

    /**
     * Simpan / perbarui api_base_url + api_key (kredensial dari sistem User).
     */
    public function update(Request $request)
    {
        $integration = UserIntegration::firstOrNew(['user_id' => $request->user()->id]);

        $data = $request->validate([
            'api_base_url' => 'required|url|max:255',
            // Wajib diisi hanya kalau ini pengaturan pertama kali (belum ada api_key tersimpan).
            // Kalau sudah pernah diisi, boleh dikosongkan supaya api_key lama tetap dipakai.
            'api_key' => ($integration->exists && $integration->api_key ? 'nullable' : 'required') . '|string|max:2000',
        ]);

        $integration->api_base_url = rtrim($data['api_base_url'], '/');
        if (!empty($data['api_key'])) {
            $integration->api_key = $data['api_key'];
        }
        $integration->status_koneksi = 'belum_terhubung'; // wajib test ulang kalau kredensial berubah
        $integration->save();

        return back()->with('success', 'Pengaturan API berhasil disimpan. Silakan Test Koneksi untuk memastikan kredensial valid.');
    }

    /**
     * Tombol "Test Koneksi" -> panggil API website User pakai kredensial yang tersimpan.
     */
    public function testConnection(Request $request, SurveyPushService $pushService)
    {
        $integration = $request->user()->integration;

        abort_unless($integration, 422, 'Isi API Base URL dan API Key terlebih dahulu.');

        $hasil = $pushService->testConnection($integration);

        $integration->update([
            'status_koneksi' => $hasil['sukses'] ? 'terhubung' : 'gagal',
            'last_tested_at' => now(),
            'last_test_message' => $hasil['pesan'],
        ]);

        return back()->with($hasil['sukses'] ? 'success' : 'error', $hasil['pesan']);
    }

    /**
     * Generate (atau generate ulang) webhook_token yang dikasih ke User untuk
     * dipasang di sisi website mereka, dipakai memverifikasi jawaban survei
     * yang masuk ke endpoint inbound kita.
     */
    public function regenerateWebhookToken(Request $request)
    {
        $integration = UserIntegration::firstOrCreate(['user_id' => $request->user()->id]);

        $tokenBaru = $integration->generateWebhookToken();

        return back()
            ->with('success', 'Webhook Token berhasil digenerate. Salin sekarang — token ini tidak akan ditampilkan lagi setelah Anda meninggalkan halaman ini.')
            ->with('webhook_token_baru', $tokenBaru);
    }
}
