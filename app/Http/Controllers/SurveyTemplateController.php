<?php

namespace App\Http\Controllers;

use App\Models\SurveyTemplate;
use App\Services\SurveyPushService;
use Illuminate\Http\Request;

class SurveyTemplateController extends Controller
{
    /**
     * Query template sesuai user yang login.
     *
     * Superadmin -> semua template
     * User biasa -> hanya template miliknya
     */
    private function templateQuery()
    {
        $query = SurveyTemplate::query();

        if (!auth()->user()->isSuperadmin()) {
            $query->where('created_by', auth()->id());
        }

        return $query;
    }

    public function index()
    {
        $templates = $this->templateQuery()
            ->withCount(['questions', 'responses'])
            ->latest()
            ->get();

        return view('survey_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('survey_templates.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_survei' => 'required|string|max:50|unique:survey_templates,kode_survei',
            'judul_survei' => 'required|string|max:200',
            'unit_layanan' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif,draft',
            'popup_tampil_setelah_detik' => 'nullable|integer|min:0|max:120',
            'popup_frekuensi' => 'required|in:setiap_kunjungan,sekali_per_sesi,sekali_per_hari,sekali_selamanya',
            'popup_jam_mulai' => 'nullable|date_format:H:i',
            'popup_jam_selesai' => 'nullable|date_format:H:i|after:popup_jam_mulai',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pemilik survei
        |--------------------------------------------------------------------------
        */
        $data['created_by'] = auth()->id();

        $template = SurveyTemplate::create($data);

        /*
        |--------------------------------------------------------------------------
        | Field identitas default
        |--------------------------------------------------------------------------
        */
        $template->identityFields()->createMany([
            [
                'label' => 'Nama Lengkap',
                'field_key' => 'nama_responden',
                'tipe' => 'text',
                'is_default' => true,
                'urutan' => 1,
                'wajib_diisi' => false,
            ],
            [
                'label' => 'Email',
                'field_key' => 'email',
                'tipe' => 'email',
                'is_default' => true,
                'urutan' => 2,
                'wajib_diisi' => false,
            ],
        ]);

        return redirect()
            ->route('survey-templates.index')
            ->with(
                'success',
                'Template survei berhasil dibuat. Silakan tambahkan pertanyaan survei.'
            );
    }

    public function edit(SurveyTemplate $surveyTemplate)
    {
        /*
        |--------------------------------------------------------------------------
        | User biasa tidak boleh membuka template milik user lain
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        return view('survey_templates.form', [
            'template' => $surveyTemplate
        ]);
    }

    public function update(
        Request $request,
        SurveyTemplate $surveyTemplate,
        SurveyPushService $pushService
    ) {
        /*
        |--------------------------------------------------------------------------
        | Pastikan template milik user yang sedang login
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        $data = $request->validate([
            'kode_survei' => 'required|string|max:50|unique:survey_templates,kode_survei,' . $surveyTemplate->id,
            'judul_survei' => 'required|string|max:200',
            'unit_layanan' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif,draft',
            'popup_tampil_setelah_detik' => 'nullable|integer|min:0|max:120',
            'popup_frekuensi' => 'required|in:setiap_kunjungan,sekali_per_sesi,sekali_per_hari,sekali_selamanya',
            'popup_jam_mulai' => 'nullable|date_format:H:i',
            'popup_jam_selesai' => 'nullable|date_format:H:i|after:popup_jam_mulai',
        ]);

        $perluPush = $data['status'] === 'aktif';

        $surveyTemplate->update($data);

        if ($perluPush) {
            $hasil = $pushService->pushSurvey($surveyTemplate);

            return redirect()
                ->route('survey-templates.index')
                ->with(
                    $hasil['sukses'] ? 'success' : 'error',
                    'Template survei berhasil diperbarui. ' . $hasil['pesan']
                );
        }

        return redirect()
            ->route('survey-templates.index')
            ->with('success', 'Template survei berhasil diperbarui.');
    }

    public function destroy(SurveyTemplate $surveyTemplate)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan user tidak bisa menghapus survei user lain
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        $surveyTemplate->delete();

        return back()->with(
            'success',
            'Template survei berhasil dihapus.'
        );
    }

    /**
     * Proteksi kepemilikan template.
     */
    private function authorizeTemplate(SurveyTemplate $surveyTemplate): void
    {
        if (
            !auth()->user()->isSuperadmin() &&
            (int) $surveyTemplate->created_by !== (int) auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses ke template survei ini.');
        }
    }
}