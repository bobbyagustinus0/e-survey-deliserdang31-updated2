<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Daftar status yang tersedia, dipakai untuk dropdown filter
     * dan validasi saat update status.
     */
    private const STATUS_LIST = ['Baru diterima', 'Diproses', 'Selesai'];

    public function index(Request $request)
    {
        $query = Pengaduan::query()
            ->where('sumber_dinas', 'damkar');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dari')) {
            $query->whereDate('waktu', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('waktu', '<=', $request->sampai);
        }

        $pengaduan = $query
            ->latest('waktu')
            ->paginate(15)
            ->withQueryString();

        $statusList = self::STATUS_LIST;

        return view('pengaduan.index', compact('pengaduan', 'statusList'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $this->authorizeSumber($pengaduan);

        return view('pengaduan.show', [
            'item' => $pengaduan,
            'statusList' => self::STATUS_LIST,
        ]);
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $this->authorizeSumber($pengaduan);

        $request->validate([
            'status' => 'required|in:' . implode(',', self::STATUS_LIST),
        ]);

        $pengaduan->status = $request->status;
        $pengaduan->save();

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Jaga-jaga: kalau nanti ada dinas lain (dinsos, disparbud) yang juga
     * pakai tabel dinas_pengaduan yang sama, pastikan hanya baris milik
     * 'damkar' yang bisa diakses lewat controller ini.
     */
    private function authorizeSumber(Pengaduan $pengaduan): void
    {
        if ($pengaduan->sumber_dinas !== 'damkar') {
            abort(403, 'Anda tidak memiliki akses ke data pengaduan ini.');
        }
    }
}
