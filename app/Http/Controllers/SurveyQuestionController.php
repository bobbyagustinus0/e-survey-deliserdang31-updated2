<?php

namespace App\Http\Controllers;

use App\Models\SurveyQuestion;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    public function index(SurveyTemplate $surveyTemplate)
    {
        $questions = $surveyTemplate->questions;
        $identityFields = $surveyTemplate->identityFields;
        return view('survey_questions.index', ['template' => $surveyTemplate, 'questions' => $questions, 'identityFields' => $identityFields]);
    }

    public function store(Request $request, SurveyTemplate $surveyTemplate)
    {
        $data = $request->validate([
            'kategori' => 'nullable|string|max:150',
            'pertanyaan' => 'required|string',
            'tipe_jawaban' => 'required|in:skala_ikm,pilihan_ganda,rating_bintang,isian_singkat,esai',
            'opsi_jawaban' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
            'wajib_diisi' => 'nullable|boolean',
        ]);

        $data['survey_template_id'] = $surveyTemplate->id;
        $data['urutan'] = $data['urutan'] ?? ($surveyTemplate->questions()->max('urutan') + 1);
        $data['wajib_diisi'] = $request->boolean('wajib_diisi');

        if ($data['tipe_jawaban'] === 'pilihan_ganda' && !empty($data['opsi_jawaban'])) {
            $data['opsi_jawaban'] = array_map('trim', explode("\n", $data['opsi_jawaban']));
        } else {
            $data['opsi_jawaban'] = null;
        }

        SurveyQuestion::create($data);

        return back()->with('success', 'Pertanyaan survei berhasil ditambahkan.');
    }

    public function update(Request $request, SurveyTemplate $surveyTemplate, SurveyQuestion $question)
    {
        $data = $request->validate([
            'kategori' => 'nullable|string|max:150',
            'pertanyaan' => 'required|string',
            'tipe_jawaban' => 'required|in:skala_ikm,pilihan_ganda,rating_bintang,isian_singkat,esai',
            'opsi_jawaban' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
            'wajib_diisi' => 'nullable|boolean',
        ]);

        $data['wajib_diisi'] = $request->boolean('wajib_diisi');

        if ($data['tipe_jawaban'] === 'pilihan_ganda' && !empty($data['opsi_jawaban'])) {
            $data['opsi_jawaban'] = array_map('trim', explode("\n", $data['opsi_jawaban']));
        } else {
            $data['opsi_jawaban'] = null;
        }

        $question->update($data);

        return back()->with('success', 'Pertanyaan survei berhasil diperbarui.');
    }

    public function destroy(SurveyTemplate $surveyTemplate, SurveyQuestion $question)
    {
        $question->delete();
        return back()->with('success', 'Pertanyaan survei berhasil dihapus.');
    }
}
