<?php

namespace App\Http\Controllers;

use App\Models\SurveyQuestion;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    /**
     * Pastikan template boleh diakses oleh user yang sedang login.
     *
     * Superadmin:
     * - Boleh mengakses semua template.
     *
     * User biasa:
     * - Hanya boleh mengakses template yang dibuat sendiri.
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

    /**
     * Pastikan question benar-benar milik template yang sedang diproses.
     */
    private function authorizeQuestion(
        SurveyTemplate $surveyTemplate,
        SurveyQuestion $question
    ): void {
        if (
            (int) $question->survey_template_id !==
            (int) $surveyTemplate->id
        ) {
            abort(404, 'Pertanyaan tidak ditemukan pada template survei ini.');
        }
    }

    public function index(SurveyTemplate $surveyTemplate)
    {
        /*
        |--------------------------------------------------------------------------
        | Proteksi template
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        $questions = $surveyTemplate
            ->questions()
            ->orderBy('urutan')
            ->get();

        $identityFields = $surveyTemplate
            ->identityFields()
            ->orderBy('urutan')
            ->get();

        return view(
            'survey_questions.index',
            [
                'template' => $surveyTemplate,
                'questions' => $questions,
                'identityFields' => $identityFields,
            ]
        );
    }

    public function store(
        Request $request,
        SurveyTemplate $surveyTemplate
    ) {
        /*
        |--------------------------------------------------------------------------
        | Proteksi template
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        $data = $request->validate([
            'kategori' => 'nullable|string|max:150',
            'pertanyaan' => 'required|string',
            'tipe_jawaban' => 'required|in:skala_ikm,pilihan_ganda,rating_bintang,isian_singkat,esai',
            'opsi_jawaban' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
            'wajib_diisi' => 'nullable|boolean',
        ]);

        $data['survey_template_id'] = $surveyTemplate->id;

        $data['urutan'] = $data['urutan']
            ?? ($surveyTemplate->questions()->max('urutan') + 1);

        $data['wajib_diisi'] = $request->boolean('wajib_diisi');

        if (
            $data['tipe_jawaban'] === 'pilihan_ganda' &&
            !empty($data['opsi_jawaban'])
        ) {
            $data['opsi_jawaban'] = array_map(
                'trim',
                explode("\n", $data['opsi_jawaban'])
            );
        } else {
            $data['opsi_jawaban'] = null;
        }

        SurveyQuestion::create($data);

        return back()->with(
            'success',
            'Pertanyaan survei berhasil ditambahkan.'
        );
    }

    public function update(
        Request $request,
        SurveyTemplate $surveyTemplate,
        SurveyQuestion $question
    ) {
        /*
        |--------------------------------------------------------------------------
        | Proteksi template
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        /*
        |--------------------------------------------------------------------------
        | Pastikan pertanyaan milik template ini
        |--------------------------------------------------------------------------
        */
        $this->authorizeQuestion(
            $surveyTemplate,
            $question
        );

        $data = $request->validate([
            'kategori' => 'nullable|string|max:150',
            'pertanyaan' => 'required|string',
            'tipe_jawaban' => 'required|in:skala_ikm,pilihan_ganda,rating_bintang,isian_singkat,esai',
            'opsi_jawaban' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
            'wajib_diisi' => 'nullable|boolean',
        ]);

        $data['wajib_diisi'] = $request->boolean('wajib_diisi');

        if (
            $data['tipe_jawaban'] === 'pilihan_ganda' &&
            !empty($data['opsi_jawaban'])
        ) {
            $data['opsi_jawaban'] = array_map(
                'trim',
                explode("\n", $data['opsi_jawaban'])
            );
        } else {
            $data['opsi_jawaban'] = null;
        }

        $question->update($data);

        return back()->with(
            'success',
            'Pertanyaan survei berhasil diperbarui.'
        );
    }

    public function destroy(
        SurveyTemplate $surveyTemplate,
        SurveyQuestion $question
    ) {
        /*
        |--------------------------------------------------------------------------
        | Proteksi template
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        /*
        |--------------------------------------------------------------------------
        | Pastikan pertanyaan memang milik template
        |--------------------------------------------------------------------------
        */
        $this->authorizeQuestion(
            $surveyTemplate,
            $question
        );

        $question->delete();

        return back()->with(
            'success',
            'Pertanyaan survei berhasil dihapus.'
        );
    }
}