<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyResponseController extends Controller
{
    public function index(Request $request)
    {
        $query = SurveyResponse::with('template');

        if ($request->filled('template_id')) {
            $query->where('survey_template_id', $request->template_id);
        }
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_isi', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_isi', '<=', $request->sampai);
        }

        $responses = $query->latest('tanggal_isi')->paginate(15)->withQueryString();
        $templates = SurveyTemplate::orderBy('judul_survei')->get();

        // Kolom data diri ditampilkan terpisah (bukan digabung jadi 1 teks).
        // Kalau difilter ke 1 template tertentu -> pakai field template itu.
        // Kalau "Semua Survei" -> gabungan (union) field dari semua template,
        // supaya kolomnya tetap konsisten tanpa harus pilih filter dulu.
        if ($request->filled('template_id')) {
            $templateTerpilih = $templates->firstWhere('id', (int) $request->template_id);
            $kolomField = $templateTerpilih
                ? $templateTerpilih->identityFields()
                    ->whereNotIn('field_key', ['nama_responden', 'email'])
                    ->orderBy('urutan')
                    ->get()
                : collect();
        } else {
            $kolomField = \App\Models\SurveyIdentityField::whereIn('survey_template_id', $templates->pluck('id'))
                ->whereNotIn('field_key', ['nama_responden', 'email'])
                ->orderBy('urutan')
                ->get()
                ->unique('field_key')
                ->values();
        }

        return view('survey_responses.index', compact('responses', 'templates', 'kolomField'));
    }

    public function show(SurveyResponse $surveyResponse)
    {
        $surveyResponse->load(['template.identityFields', 'answers.question']);
        return view('survey_responses.show', ['response' => $surveyResponse]);
    }

    public function destroy(SurveyResponse $surveyResponse)
    {
        $surveyResponse->delete();
        return back()->with('success', 'Data respon survei berhasil dihapus.');
    }
}
