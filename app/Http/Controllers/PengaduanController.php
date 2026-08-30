<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

/**
 * Halaman "Pengaduan Masyarakat" di sidebar E-Survey.
 *
 * Data di sini dibaca langsung dari tabel `dinas_pengaduan` (lihat model
 * App\Models\Pengaduan) yang diisi oleh backend Node.js dinas (mis. Damkar
 * Deli Serdang) saat warga mengirim form "Lapor" di website mereka.
 * Laravel di sini murni MEMBACA data yang sudah tersimpan -- tidak ada
 * proses simpan/insert dari sisi Laravel untuk pengaduan.
 */
class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('dari')) {
            $query->whereDate('waktu', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('waktu', '<=', $request->sampai);
        }

        if ($request->filled('cari')) {
            $kata = $request->cari;
            $query->where(function ($q) use ($kata) {
                $q->where('nama', 'like', "%{$kata}%")
                    ->orWhere('kontak', 'like', "%{$kata}%")
                    ->orWhere('lokasi', 'like', "%{$kata}%")
                    ->orWhere('id', 'like', "%{$kata}%");
            });
        }

        $pengaduan = $query->latest('waktu')->paginate(15)->withQueryString();

        $kategoriList = Pengaduan::query()
            ->select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->sort()
            ->values();

        return view('pengaduan.index', compact('pengaduan', 'kategoriList'));
    }

    public function show(Pengaduan $pengaduan)
    {
        return view('pengaduan.show', compact('pengaduan'));
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();

        return back()->with('success', 'Data pengaduan berhasil dihapus.');
    }
}
