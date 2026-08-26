<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Query template sesuai user login.
     */
    private function templateQuery()
    {
        $query = SurveyTemplate::query();

        if (!auth()->user()->isSuperadmin()) {
            $query->where('created_by', auth()->id());
        }

        return $query;
    }

    /**
     * Query response sesuai pemilik template.
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

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Template yang boleh dilihat
        |--------------------------------------------------------------------------
        */
        $templates = $this->templateQuery()
            ->orderBy('judul_survei')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Respon yang boleh dilihat
        |--------------------------------------------------------------------------
        */
        $query = $this->responseQuery();

        if ($request->filled('template_id')) {
            $query->where(
                'survey_template_id',
                $request->template_id
            );
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

        /*
        |--------------------------------------------------------------------------
        | Statistik utama
        |--------------------------------------------------------------------------
        */
        $totalResponden = (clone $query)->count();

        $rataIkm = round(
            (clone $query)
                ->whereNotNull('nilai_ikm')
                ->avg('nilai_ikm') ?? 0,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | Sebaran kategori IKM
        |--------------------------------------------------------------------------
        */
        $sebaranKategori = [
            'A (Sangat Baik)' =>
                (clone $query)
                    ->where('nilai_ikm', '>=', 88.31)
                    ->count(),

            'B (Baik)' =>
                (clone $query)
                    ->whereBetween(
                        'nilai_ikm',
                        [76.61, 88.30]
                    )
                    ->count(),

            'C (Kurang Baik)' =>
                (clone $query)
                    ->whereBetween(
                        'nilai_ikm',
                        [65.00, 76.60]
                    )
                    ->count(),

            'D (Tidak Baik)' =>
                (clone $query)
                    ->where('nilai_ikm', '<', 65.00)
                    ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Sebaran gender
        |--------------------------------------------------------------------------
        */
        $sebaranGender = [
            'Laki-laki' =>
                (clone $query)
                    ->where('jenis_kelamin', 'L')
                    ->count(),

            'Perempuan' =>
                (clone $query)
                    ->where('jenis_kelamin', 'P')
                    ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | IKM per template
        |--------------------------------------------------------------------------
        */
        $ikmPerTemplate = $this->templateQuery()
            ->withCount('responses')
            ->get()
            ->map(function ($template) {

                $responseQuery = $template->responses();

                return [
                    'judul' => $template->judul_survei,

                    'jumlah' => $template->responses_count,

                    'rata_ikm' => round(
                        $responseQuery
                            ->whereNotNull('nilai_ikm')
                            ->avg('nilai_ikm') ?? 0,
                        2
                    ),
                ];
            });

        return view(
            'reports.index',
            compact(
                'templates',
                'totalResponden',
                'rataIkm',
                'sebaranKategori',
                'sebaranGender',
                'ikmPerTemplate'
            )
        );
    }

    public function export(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Export hanya data yang boleh dilihat user
        |--------------------------------------------------------------------------
        */
        $query = $this->responseQuery()
            ->with('template');

        if ($request->filled('template_id')) {
            $query->where(
                'survey_template_id',
                $request->template_id
            );
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

        $data = $query
            ->latest('tanggal_isi')
            ->get();

        $filename =
            'laporan-survei-' .
            now()->format('Ymd-His') .
            '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($data) {

            $handle = fopen(
                'php://output',
                'w'
            );

            fputcsv($handle, [
                'No',
                'Survei',
                'Nama Responden',
                'Jenis Kelamin',
                'Nilai IKM',
                'Kategori',
                'Tanggal Isi'
            ]);

            foreach ($data as $i => $row) {

                fputcsv($handle, [
                    $i + 1,
                    $row->template->judul_survei ?? '-',
                    $row->nama_responden ?? 'Anonim',
                    $row->jenis_kelamin ?? '-',
                    $row->nilai_ikm ?? '-',
                    $row->kategoriMutu(),
                    optional($row->tanggal_isi)
                        ->format('d-m-Y H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }
}