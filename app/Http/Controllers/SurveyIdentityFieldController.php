<?php

namespace App\Http\Controllers;

use App\Models\SurveyIdentityField;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyIdentityFieldController extends Controller
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
            abort(
                403,
                'Anda tidak memiliki akses ke template survei ini.'
            );
        }
    }

    /**
     * Pastikan identity field benar-benar milik template tersebut.
     */
    private function authorizeIdentityField(
        SurveyTemplate $surveyTemplate,
        SurveyIdentityField $identityField
    ): void {
        if (
            (int) $identityField->survey_template_id !==
            (int) $surveyTemplate->id
        ) {
            abort(
                404,
                'Field data diri tidak ditemukan pada template survei ini.'
            );
        }
    }

    public function store(
        Request $request,
        SurveyTemplate $surveyTemplate
    ) {
        /*
        |--------------------------------------------------------------------------
        | Pastikan user memiliki akses ke template
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        $data = $this->validasi($request);

        $data['survey_template_id'] = $surveyTemplate->id;

        $data['field_key'] = SurveyIdentityField::buatKeyUnik(
            $data['label'],
            $surveyTemplate->id
        );

        $data['urutan'] =
            $data['urutan']
            ?? ($surveyTemplate->identityFields()->max('urutan') + 1);

        $data['wajib_diisi'] = $request->boolean('wajib_diisi');

        if (
            $data['tipe'] === 'pilihan' &&
            !empty($data['opsi_pilihan'])
        ) {
            $data['opsi_pilihan'] = array_map(
                'trim',
                explode("\n", $data['opsi_pilihan'])
            );
        } else {
            $data['opsi_pilihan'] = null;
        }

        SurveyIdentityField::create($data);

        return back()->with(
            'success',
            'Field data diri berhasil ditambahkan.'
        );
    }

    public function update(
        Request $request,
        SurveyTemplate $surveyTemplate,
        SurveyIdentityField $identityField
    ) {
        /*
        |--------------------------------------------------------------------------
        | Pastikan user memiliki akses ke template
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        /*
        |--------------------------------------------------------------------------
        | Pastikan field memang milik template tersebut
        |--------------------------------------------------------------------------
        */
        $this->authorizeIdentityField(
            $surveyTemplate,
            $identityField
        );

        $data = $this->validasi($request);

        $data['wajib_diisi'] = $request->boolean('wajib_diisi');

        /*
        |--------------------------------------------------------------------------
        | PENTING
        |--------------------------------------------------------------------------
        | field_key sengaja tidak diubah meskipun label berubah.
        |
        | Ini menjaga jawaban responden lama tetap terhubung
        | dengan field yang sama.
        |--------------------------------------------------------------------------
        */

        if (
            $data['tipe'] === 'pilihan' &&
            !empty($data['opsi_pilihan'])
        ) {
            $data['opsi_pilihan'] = array_map(
                'trim',
                explode("\n", $data['opsi_pilihan'])
            );
        } else {
            $data['opsi_pilihan'] = null;
        }

        $identityField->update($data);

        return back()->with(
            'success',
            'Field data diri berhasil diperbarui.'
        );
    }

    public function destroy(
        SurveyTemplate $surveyTemplate,
        SurveyIdentityField $identityField
    ) {
        /*
        |--------------------------------------------------------------------------
        | Pastikan user memiliki akses ke template
        |--------------------------------------------------------------------------
        */
        $this->authorizeTemplate($surveyTemplate);

        /*
        |--------------------------------------------------------------------------
        | Pastikan field memang milik template tersebut
        |--------------------------------------------------------------------------
        */
        $this->authorizeIdentityField(
            $surveyTemplate,
            $identityField
        );

        $identityField->delete();

        return back()->with(
            'success',
            'Field data diri berhasil dihapus.'
        );
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'label' => 'required|string|max:150',
            'tipe' => 'required|in:text,email,angka,pilihan',
            'opsi_pilihan' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
            'wajib_diisi' => 'nullable|boolean',
        ]);
    }
}