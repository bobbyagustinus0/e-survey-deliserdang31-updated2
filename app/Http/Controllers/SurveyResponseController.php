<?php

namespace App\Http\Controllers;

use App\Models\SurveyIdentityField;
use App\Models\SurveyResponse;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyResponseController extends Controller
{
    /**
     * Query respon sesuai pemilik template.
     *
     * Superadmin -> semua respon
     * User biasa -> respon dari template miliknya
     */
    private function responseQuery()
    {
        $query = SurveyResponse::query();

        if (!auth()->user()->isSuperadmin()) {
            $query->whereHas('template', function ($q) {
                $q->where('created_by', auth()->id());
            });
        }

        return $query;
    }

    /**
     * Query template sesuai user.
     */
    private function templateQuery()
    {
        $query = SurveyTemplate::query();

        if (!auth()->user()->isSuperadmin()) {
            $query->where('created_by', auth()->id());
        }

        return $query;
    }

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Respon
        |--------------------------------------------------------------------------
        */
        $query = $this->responseQuery()
            ->with('template');

        if ($request->filled('template_id')) {
            /*
            |--------------------------------------------------------------------------
            | Pastikan template yang dipilih memang boleh dilihat user
            |--------------------------------------------------------------------------
            */
            $query->where('survey_template_id', $request->template_id);
        }

        if ($request->filled('dari')) {
            $query->whereDate(
                'tanggal_isi',
                '>=',
                $request->dari
            );
        }

        if ($request->filled('sampai')) {
            $query->whereDate(
                'tanggal_isi',
                '<=',
                $request->sampai
            );
        }

        $responses = $query
            ->latest('tanggal_isi')
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Template filter
        |--------------------------------------------------------------------------
        */
        $templates = $this->templateQuery()
            ->orderBy('judul_survei')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Field identitas
        |--------------------------------------------------------------------------
        */
        if ($request->filled('template_id')) {

            $templateTerpilih = $templates->firstWhere(
                'id',
                (int) $request->template_id
            );

            $kolomField = $templateTerpilih
                ? $templateTerpilih
                    ->identityFields()
                    ->whereNotIn(
                        'field_key',
                        ['nama_responden', 'email']
                    )
                    ->orderBy('urutan')
                    ->get()
                : collect();

        } else {

            $kolomField = SurveyIdentityField::whereIn(
                    'survey_template_id',
                    $templates->pluck('id')
                )
                ->whereNotIn(
                    'field_key',
                    ['nama_responden', 'email']
                )
                ->orderBy('urutan')
                ->get()
                ->unique('field_key')
                ->values();
        }

        /*
        |--------------------------------------------------------------------------
        | Kolom Responden / Email bersifat kondisional
        |--------------------------------------------------------------------------
        | Platform ini dipakai bersama beberapa dinas — sebagian template masih
        | mengaktifkan field "Nama Lengkap" / "Email" bawaan, sebagian sudah
        | menghapusnya (mis. template Damkar). Supaya tabel tidak menampilkan
        | kolom kosong ("Anonim" / "-" di semua baris) untuk template yang sudah
        | tidak memakainya, kolom ini hanya ditampilkan kalau ADA setidaknya satu
        | respon di halaman ini yang punya nilai nama_responden / email.
        */
        $tampilkanKolomResponden = $responses->contains(
            fn ($r) => filled($r->nama_responden)
        );

        $tampilkanKolomEmail = $responses->contains(
            fn ($r) => filled($r->email)
        );

        return view(
            'survey_responses.index',
            compact(
                'responses',
                'templates',
                'kolomField',
                'tampilkanKolomResponden',
                'tampilkanKolomEmail'
            )
        );
    }

    public function show(SurveyResponse $surveyResponse)
    {
        /*
        |--------------------------------------------------------------------------
        | Proteksi respon
        |--------------------------------------------------------------------------
        */
        $this->authorizeResponse($surveyResponse);

        $surveyResponse->load([
            'template.identityFields',
            'answers.question'
        ]);

        return view(
            'survey_responses.show',
            [
                'response' => $surveyResponse
            ]
        );
    }

    public function destroy(SurveyResponse $surveyResponse)
    {
        /*
        |--------------------------------------------------------------------------
        | Proteksi hapus respon
        |--------------------------------------------------------------------------
        */
        $this->authorizeResponse($surveyResponse);

        $surveyResponse->delete();

        return back()->with(
            'success',
            'Data respon survei berhasil dihapus.'
        );
    }

    /**
     * Pastikan respon berasal dari template milik user.
     */
    private function authorizeResponse(SurveyResponse $surveyResponse): void
    {
        if (auth()->user()->isSuperadmin()) {
            return;
        }

        $pemilikTemplate = $surveyResponse
            ->template()
            ->value('created_by');

        if ((int) $pemilikTemplate !== (int) auth()->id()) {
            abort(
                403,
                'Anda tidak memiliki akses ke respon survei ini.'
            );
        }
    }
}
