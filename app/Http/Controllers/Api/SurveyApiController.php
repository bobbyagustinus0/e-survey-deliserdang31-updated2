<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SurveyAnswer;
use App\Models\SurveyResponse;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyApiController extends Controller
{
    /**
     * Daftar survei yang sedang aktif (bisa diisi).
     * GET /api/survey-templates
     */
    public function index()
    {
        $templates = SurveyTemplate::where('status', 'aktif')
            ->withCount('questions')
            ->latest()
            ->get(['id', 'kode_survei', 'judul_survei', 'unit_layanan', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai']);

        return response()->json([
            'success' => true,
            'data' => $templates,
        ]);
    }

    /**
     * Detail 1 survei beserta daftar pertanyaan (dikelompokkan per kategori/tahap)
     * dan daftar field data diri yang perlu diisi (untuk dirender di app mobile).
     * GET /api/survey-templates/{id}
     */
    public function show(SurveyTemplate $surveyTemplate)
    {
        abort_unless($surveyTemplate->status === 'aktif', 404, 'Survei tidak tersedia / sudah ditutup.');

        $surveyTemplate->load(['questions', 'identityFields']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $surveyTemplate->id,
                'judul_survei' => $surveyTemplate->judul_survei,
                'unit_layanan' => $surveyTemplate->unit_layanan,
                'deskripsi' => $surveyTemplate->deskripsi,

                'field_data_diri' => array_merge(
                    [
                        [
                            'field_key' => 'nama_responden',
                            'label' => $surveyTemplate->label_nama,
                            'tipe' => 'text',
                            'wajib_diisi' => $surveyTemplate->wajib_nama,
                            'tampilkan' => $surveyTemplate->tampilkan_nama,
                            'opsi_pilihan' => null,
                        ],
                        [
                            'field_key' => 'email',
                            'label' => $surveyTemplate->label_email,
                            'tipe' => 'email',
                            'wajib_diisi' => $surveyTemplate->wajib_email,
                            'tampilkan' => $surveyTemplate->tampilkan_email,
                            'opsi_pilihan' => null,
                        ],
                    ],
                    $surveyTemplate->identityFields->map(fn ($f) => [
                        'field_key' => $f->field_key,
                        'label' => $f->label,
                        'tipe' => $f->tipe,
                        'wajib_diisi' => $f->wajib_diisi,
                        'tampilkan' => true,
                        'opsi_pilihan' => $f->opsi_pilihan,
                    ])->all()
                ),

                'kategori_pertanyaan' => $surveyTemplate->questions
                    ->groupBy(fn ($q) => $q->kategori ?: 'Pernyataan Umum')
                    ->map(fn ($daftar, $kategori) => [
                        'kategori' => $kategori,
                        'pertanyaan' => $daftar->map(fn ($q) => [
                            'id' => $q->id,
                            'pertanyaan' => $q->pertanyaan,
                            'tipe_jawaban' => $q->tipe_jawaban,
                            'opsi_jawaban' => $q->opsi_jawaban,
                            'wajib_diisi' => $q->wajib_diisi,
                            'urutan' => $q->urutan,
                        ])->values(),
                    ])->values(),
            ],
        ]);
    }

    /**
     * Submit jawaban survei dari app luar (harus login / bawa Bearer Token).
     * POST /api/survey-templates/{id}/submit
     * body: {
     *   "nama_responden": "Budi" (opsional, override nama akun),
     *   "email": "budi@mail.com" (opsional, override email akun),
     *   "data_tambahan": { "usia": "25", "pekerjaan": "Wiraswasta" },
     *   "jawaban": { "1": "4", "2": "3", "5": "Sangat mudah digunakan" }
     * }
     */
    public function submit(Request $request, SurveyTemplate $surveyTemplate)
    {
        abort_unless($surveyTemplate->status === 'aktif', 404, 'Survei tidak tersedia / sudah ditutup.');

        $request->validate([
            'nama_responden' => $surveyTemplate->wajib_nama ? 'required|string|max:150' : 'nullable|string|max:150',
            'email' => $surveyTemplate->wajib_email ? 'required|email|max:150' : 'nullable|email|max:150',
            'jawaban' => 'required|array',
        ]);

        $aturanField = [];
        foreach ($surveyTemplate->identityFields as $f) {
            $rule = $f->wajib_diisi ? 'required' : 'nullable';
            if ($f->tipe === 'email') $rule .= '|email';
            if ($f->tipe === 'angka') $rule .= '|numeric';
            $aturanField["data_tambahan.{$f->field_key}"] = $rule;
        }
        $request->validate($aturanField);

        $user = $request->user();

        $response = SurveyResponse::create([
            'survey_template_id' => $surveyTemplate->id,
            'user_id' => $user->id,
            'nama_responden' => $request->filled('nama_responden') ? $request->nama_responden : $user->name,
            'email' => $request->filled('email') ? $request->email : $user->email,
            'no_hp' => $user->no_hp,
            'data_tambahan' => $request->input('data_tambahan', []),
            'ip_address' => $request->ip(),
            'tanggal_isi' => now(),
        ]);

        $totalPersen = 0;
        $countTerukur = 0;

        foreach ($request->jawaban as $questionId => $jawaban) {
            $question = $surveyTemplate->questions()->find($questionId);
            if (!$question) continue;

            $nilaiSkala = null;
            $maksimalSkala = null;

            if ($question->tipe_jawaban === 'skala_ikm' && is_numeric($jawaban)) {
                $nilaiSkala = (int) $jawaban;
                $maksimalSkala = 4;
            } elseif ($question->tipe_jawaban === 'rating_bintang' && is_numeric($jawaban)) {
                $nilaiSkala = (int) $jawaban;
                $maksimalSkala = (is_array($question->opsi_jawaban) && count($question->opsi_jawaban) >= 2)
                    ? count($question->opsi_jawaban)
                    : 5;
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

        return response()->json([
            'success' => true,
            'message' => 'Jawaban survei berhasil dikirim. Terima kasih!',
            'data' => [
                'response_id' => $response->id,
                'nilai_ikm' => $response->nilai_ikm,
                'kategori' => $response->kategoriMutu(),
            ],
        ], 201);
    }

    /**
     * Daftar respon/jawaban yang sudah masuk untuk 1 survei (dipakai admin/sistem luar
     * untuk SINKRONISASI DATA - misal ditarik berkala oleh aplikasi SIPANDU).
     * GET /api/survey-templates/{id}/responses?per_page=20&dari=2026-08-01&sampai=2026-08-31
     * Wajib login dengan akun yang punya akses menu "survey_response".
     */
    public function responses(Request $request, SurveyTemplate $surveyTemplate)
    {
        $user = $request->user();
        abort_unless($user->isSuperadmin() || $user->hasMenuAccess('survey_response'), 403, 'Akun Anda tidak punya akses untuk menarik data respon survei.');

        $query = $surveyTemplate->responses()->with(['answers.question']);

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_isi', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_isi', '<=', $request->sampai);
        }

        $perPage = min((int) $request->get('per_page', 20), 100);
        $responses = $query->latest('tanggal_isi')->paginate($perPage);

        $data = $responses->getCollection()->map(fn ($r) => [
            'id' => $r->id,
            'nama_responden' => $r->nama_responden,
            'email' => $r->email,
            'data_tambahan' => $r->data_tambahan,
            'nilai_ikm' => $r->nilai_ikm,
            'kategori' => $r->kategoriMutu(),
            'tanggal_isi' => optional($r->tanggal_isi)->toIso8601String(),
            'jawaban' => $r->answers->map(fn ($a) => [
                'pertanyaan_id' => $a->survey_question_id,
                'pertanyaan' => $a->question->pertanyaan ?? null,
                'kategori' => $a->question->kategori ?? null,
                'jawaban' => $a->jawaban,
                'nilai_skala' => $a->nilai_skala,
            ]),
        ]);

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $responses->currentPage(),
                'last_page' => $responses->lastPage(),
                'per_page' => $responses->perPage(),
                'total' => $responses->total(),
            ],
        ]);
    }
}
