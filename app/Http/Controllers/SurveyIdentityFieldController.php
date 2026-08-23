<?php

namespace App\Http\Controllers;

use App\Models\SurveyIdentityField;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyIdentityFieldController extends Controller
{
    public function store(Request $request, SurveyTemplate $surveyTemplate)
    {
        $data = $this->validasi($request);

        $data['survey_template_id'] = $surveyTemplate->id;
        $data['field_key'] = SurveyIdentityField::buatKeyUnik($data['label'], $surveyTemplate->id);
        $data['urutan'] = $data['urutan'] ?? ($surveyTemplate->identityFields()->max('urutan') + 1);
        $data['wajib_diisi'] = $request->boolean('wajib_diisi');

        if ($data['tipe'] === 'pilihan' && !empty($data['opsi_pilihan'])) {
            $data['opsi_pilihan'] = array_map('trim', explode("\n", $data['opsi_pilihan']));
        } else {
            $data['opsi_pilihan'] = null;
        }

        SurveyIdentityField::create($data);

        return back()->with('success', 'Field data diri berhasil ditambahkan.');
    }

    public function update(Request $request, SurveyTemplate $surveyTemplate, SurveyIdentityField $identityField)
    {
        $data = $this->validasi($request);
        $data['wajib_diisi'] = $request->boolean('wajib_diisi');

        // PENTING: field_key SENGAJA TIDAK diubah walau label diganti.
        // Ini supaya jawaban responden yang sudah tersimpan tetap "nyambung" dengan field ini,
        // baik di halaman Respon Survei maupun detail respon, walau labelnya sudah diubah berkali-kali.

        if ($data['tipe'] === 'pilihan' && !empty($data['opsi_pilihan'])) {
            $data['opsi_pilihan'] = array_map('trim', explode("\n", $data['opsi_pilihan']));
        } else {
            $data['opsi_pilihan'] = null;
        }

        $identityField->update($data);

        return back()->with('success', 'Field data diri berhasil diperbarui.');
    }

    public function destroy(SurveyTemplate $surveyTemplate, SurveyIdentityField $identityField)
    {
        $identityField->delete();
        return back()->with('success', 'Field data diri berhasil dihapus.');
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