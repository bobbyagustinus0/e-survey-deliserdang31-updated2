<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyTemplate;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isSuperadmin = $user->isSuperadmin();

        /*
        |--------------------------------------------------------------------------
        | Query Template Survei
        |--------------------------------------------------------------------------
        | Superadmin : melihat semua survei
        | User biasa : hanya survei yang dibuat olehnya
        |--------------------------------------------------------------------------
        */
        $templateQuery = SurveyTemplate::query();

        if (!$isSuperadmin) {
            $templateQuery->where('created_by', $user->id);
        }

        $totalSurvei = (clone $templateQuery)->count();

        $surveiAktif = (clone $templateQuery)
            ->where('status', 'aktif')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Query Respon
        |--------------------------------------------------------------------------
        | Respon mengikuti pemilik template surveinya.
        |
        | Jangan menggunakan SurveyResponse.user_id untuk filtering admin,
        | karena user_id adalah orang yang mengisi survei.
        |--------------------------------------------------------------------------
        */
        $responseQuery = SurveyResponse::query();

        if (!$isSuperadmin) {
            $responseQuery->whereHas('template', function ($query) use ($user) {
                $query->where('created_by', $user->id);
            });
        }

        $totalResponden = (clone $responseQuery)->count();

        /*
        |--------------------------------------------------------------------------
        | Total User
        |--------------------------------------------------------------------------
        */
        $totalUser = $isSuperadmin
            ? User::count()
            : 1;

        /*
        |--------------------------------------------------------------------------
        | Rata-rata IKM
        |--------------------------------------------------------------------------
        */
        $rataIkm = round(
            (clone $responseQuery)
                ->whereNotNull('nilai_ikm')
                ->avg('nilai_ikm') ?? 0,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | Grafik jumlah respon per bulan
        |--------------------------------------------------------------------------
        */
        $responPerBulan = (clone $responseQuery)
            ->selectRaw("
                DATE_FORMAT(tanggal_isi, '%Y-%m') as bulan,
                COUNT(*) as total
            ")
            ->where(
                'tanggal_isi',
                '>=',
                now()->subMonths(11)->startOfMonth()
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        /*
        |--------------------------------------------------------------------------
        | Rata-rata IKM per template
        |--------------------------------------------------------------------------
        */
        $ikmPerTemplate = (clone $templateQuery)
            ->withCount('responses')
            ->orderByDesc('responses_count')
            ->take(5)
            ->get()
            ->map(function ($template) {
                return [
                    'judul' => $template->judul_survei,
                    'jumlah_respon' => $template->responses_count,
                    'rata_ikm' => round(
                        $template->responses()
                            ->whereNotNull('nilai_ikm')
                            ->avg('nilai_ikm') ?? 0,
                        2
                    ),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Survei terbaru
        |--------------------------------------------------------------------------
        */
        $surveiTerbaru = (clone $templateQuery)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Respon terbaru
        |--------------------------------------------------------------------------
        */
        $responTerbaru = (clone $responseQuery)
            ->with('template')
            ->latest('tanggal_isi')
            ->take(8)
            ->get();

        return view('dashboard.index', compact(
            'totalSurvei',
            'surveiAktif',
            'totalResponden',
            'totalUser',
            'rataIkm',
            'responPerBulan',
            'ikmPerTemplate',
            'surveiTerbaru',
            'responTerbaru'
        ));
    }
}