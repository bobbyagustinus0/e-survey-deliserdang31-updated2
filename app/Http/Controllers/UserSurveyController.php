<?php

namespace App\Http\Controllers;

use App\Models\SurveyAnswer;
use App\Models\SurveyResponse;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class UserSurveyController extends Controller
{
    /**
     * Daftar survei yang sedang aktif dan bisa diisi oleh user yang login.
     */
    public function index()
    {
        $templates = SurveyTemplate::where('status', 'aktif')
            ->withCount(['responses as sudah_diisi' => function ($q) {
                $q->where('user_id', auth()->id());
            }])
            ->latest()
            ->get();

        return view('user_survey.index', compact('templates'));
    }

    public function show(SurveyTemplate $surveyTemplate)
    {
        abort_unless($surveyTemplate->status === 'aktif', 404, 'Survei tidak tersedia / sudah ditutup.');
        $surveyTemplate->load(['questions', 'identityFields']);
        return view('user_survey.form', ['template' => $surveyTemplate]);
    }

    public function store(Request $request, SurveyTemplate $surveyTemplate)
    {
        abort_unless($surveyTemplate->status === 'aktif', 404);

        $request->validate([
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

        $user = auth()->user();

        $response = SurveyResponse::create([
            'survey_template_id' => $surveyTemplate->id,
            'user_id' => $user->id,
            'nama_responden' => $user->name,
            'email' => $user->email,
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

        return redirect()->route('user-survey.index')->with('success', 'Terima kasih, jawaban survei anda berhasil dikirim.');
    }
}
