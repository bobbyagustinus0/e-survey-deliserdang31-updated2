<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

/**
 * Halaman khusus "Pengaduan Masyarakat" di sidebar E-Survey.
 *
 * Secara teknis, laporan pengaduan yang dikirim warga lewat form di website
 * Dinas (mis. Damkar Deli Serdang) masuk ke sini melalui jalur yang SAMA
 * dengan jawaban survei biasa (POST /api/webhook/survey-jawaban), hanya saja
 * "dititipkan" sebagai respon dari template survei khusus berkode
 * PENGADUAN-DAMKAR (lihat SurveyResponseRecorder & WebhookSurveyController).
 *
 * Controller ini tidak menyentuh tabel baru -- hanya menyaring SurveyResponse
 * yang templatenya berkode diawali "PENGADUAN-" supaya tampilannya rapi
 * seperti daftar pengaduan sungguhan (nama, kontak, kategori, lokasi, isi,
 * status), bukan tampilan generik "jawaban survei".
 */
class PengaduanController extends Controller
{
    /** Prefix kode survei yang dianggap sebagai "wadah" pengaduan. */
    private const KODE_PREFIX = 'PENGADUAN-';

    private function templateQuery()
    {
        $query = SurveyTemplate::query()->where('kode_survei', 'like', self::KODE_PREFIX . '%');

        if (!auth()->user()->isSuperadmin()) {
            $query->where('created_by', auth()->id());
        }

        return $query;
    }

    public function index(Request $request)
    {
        $templateIds = $this->templateQuery()->pluck('id');

        $query = SurveyResponse::query()
            ->with(['template', 'answers.question'])
            ->whereIn('survey_template_id', $templateIds);

        if ($request->filled('kategori')) {
            $query->where('data_tambahan->kategori', $request->kategori);
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_isi', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_isi', '<=', $request->sampai);
        }

        if ($request->filled('cari')) {
            $kata = $request->cari;
            $query->where(function ($q) use ($kata) {
                $q->where('nama_responden', 'like', "%{$kata}%")
                    ->orWhere('no_hp', 'like', "%{$kata}%")
                    ->orWhere('data_tambahan->lokasi', 'like', "%{$kata}%")
                    ->orWhere('data_tambahan->nomor_tiket', 'like', "%{$kata}%");
            });
        }

        $pengaduan = $query->latest('tanggal_isi')->paginate(15)->withQueryString();

        // Daftar kategori unik untuk dropdown filter
        $kategoriList = SurveyResponse::query()
            ->whereIn('survey_template_id', $templateIds)
            ->pluck('data_tambahan')
            ->map(fn ($d) => $d['kategori'] ?? null)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $totalBelumDitindak = (clone $query)->count();

        return view('pengaduan.index', compact('pengaduan', 'kategoriList', 'totalBelumDitindak'));
    }

    public function show(SurveyResponse $pengaduan)
    {
        $this->authorizeAkses($pengaduan);

        $pengaduan->load(['template', 'answers.question']);

        return view('pengaduan.show', compact('pengaduan'));
    }

    public function destroy(SurveyResponse $pengaduan)
    {
        $this->authorizeAkses($pengaduan);

        $pengaduan->delete();

        return back()->with('success', 'Data pengaduan berhasil dihapus.');
    }

    private function authorizeAkses(SurveyResponse $pengaduan): void
    {
        if (auth()->user()->isSuperadmin()) {
            return;
        }

        $pemilik = $pengaduan->template()->value('created_by');

        if ((int) $pemilik !== (int) auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pengaduan ini.');
        }
    }
}
