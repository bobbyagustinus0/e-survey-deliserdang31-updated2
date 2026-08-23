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
        $totalSurvei = SurveyTemplate::count();
        $surveiAktif = SurveyTemplate::where('status', 'aktif')->count();
        $totalResponden = SurveyResponse::count();
        $totalUser = User::count();

        $rataIkm = round(SurveyResponse::whereNotNull('nilai_ikm')->avg('nilai_ikm') ?? 0, 2);

        // Grafik jumlah respon per bulan (12 bulan terakhir)
        $responPerBulan = SurveyResponse::selectRaw("DATE_FORMAT(tanggal_isi, '%Y-%m') as bulan, COUNT(*) as total")
            ->where('tanggal_isi', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Rata-rata IKM per template survei (untuk grafik batang)
        $ikmPerTemplate = SurveyTemplate::withCount('responses')
            ->with(['responses' => function ($q) {
                $q->select('survey_template_id', DB::raw('AVG(nilai_ikm) as avg_ikm'))
                  ->groupBy('survey_template_id');
            }])
            ->orderByDesc('responses_count')
            ->take(5)
            ->get()
            ->map(function ($t) {
                return [
                    'judul' => $t->judul_survei,
                    'jumlah_respon' => $t->responses_count,
                    'rata_ikm' => round($t->responses->avg('nilai_ikm') ?? 0, 2),
                ];
            });

        $surveiTerbaru = SurveyTemplate::latest()->take(5)->get();
        $responTerbaru = SurveyResponse::with('template')->latest()->take(8)->get();

        return view('dashboard.index', compact(
            'totalSurvei', 'surveiAktif', 'totalResponden', 'totalUser', 'rataIkm',
            'responPerBulan', 'ikmPerTemplate', 'surveiTerbaru', 'responTerbaru'
        ));
    }
}
