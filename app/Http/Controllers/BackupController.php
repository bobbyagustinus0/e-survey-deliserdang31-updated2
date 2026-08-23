<?php

namespace App\Http\Controllers;

use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    protected string $backupPath = 'app/backups';

    public function index()
    {
        $dir = storage_path($this->backupPath);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $files = collect(File::files($dir))
            ->sortByDesc(fn($f) => $f->getMTime())
            ->map(fn($f) => [
                'nama' => $f->getFilename(),
                'ukuran' => round($f->getSize() / 1024, 2) . ' KB',
                'tanggal' => date('d-m-Y H:i:s', $f->getMTime()),
            ]);

        $logs = BackupLog::with('user')->latest()->take(20)->get();

        return view('backup.index', compact('files', 'logs'));
    }

    /**
     * Backup database menggunakan mysqldump (pastikan mysqldump ada di PATH -> XAMPP/Herd biasanya sudah tersedia).
     */
    public function backup(Request $request)
    {
        $dir = storage_path($this->backupPath);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $filename = 'backup-' . config('database.connections.mysql.database') . '-' . now()->format('Ymd_His') . '.sql';
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $db = config('database.connections.mysql');

        $command = [
            'mysqldump',
            '-h', $db['host'],
            '-P', (string) $db['port'],
            '-u', $db['username'],
        ];
        if (!empty($db['password'])) {
            $command[] = '-p' . $db['password'];
        }
        $command[] = $db['database'];

        $process = new Process($command);
        $process->setTimeout(300);

        try {
            $process->mustRun(function ($type, $buffer) use ($filepath) {
                if ($type === Process::OUT) {
                    File::append($filepath, $buffer);
                }
            });

            BackupLog::create([
                'nama_file' => $filename,
                'jenis' => 'backup',
                'user_id' => auth()->id(),
                'status' => 'sukses',
                'keterangan' => 'Backup database berhasil dibuat.',
            ]);

            return back()->with('success', "Backup database berhasil dibuat: $filename");
        } catch (\Throwable $e) {
            BackupLog::create([
                'nama_file' => $filename,
                'jenis' => 'backup',
                'user_id' => auth()->id(),
                'status' => 'gagal',
                'keterangan' => $e->getMessage(),
            ]);

            return back()->with('error', 'Backup gagal. Pastikan mysqldump tersedia di PATH sistem anda. Detail: ' . $e->getMessage());
        }
    }

    public function download(string $filename)
    {
        $filepath = storage_path($this->backupPath . DIRECTORY_SEPARATOR . $filename);
        abort_unless(File::exists($filepath), 404);
        return response()->download($filepath);
    }

    public function destroy(string $filename)
    {
        $filepath = storage_path($this->backupPath . DIRECTORY_SEPARATOR . $filename);
        if (File::exists($filepath)) {
            File::delete($filepath);
        }
        return back()->with('success', 'File backup berhasil dihapus.');
    }

    /**
     * Restore database dari file .sql yang diupload.
     */
    public function restore(Request $request)
    {
        $request->validate([
            'file_restore' => 'required|file|mimes:sql,txt|max:51200',
        ]);

        $uploaded = $request->file('file_restore');
        $tmpPath = $uploaded->getRealPath();

        $db = config('database.connections.mysql');

        $command = [
            'mysql',
            '-h', $db['host'],
            '-P', (string) $db['port'],
            '-u', $db['username'],
        ];
        if (!empty($db['password'])) {
            $command[] = '-p' . $db['password'];
        }
        $command[] = $db['database'];

        $process = new Process($command);
        $process->setInput(File::get($tmpPath));
        $process->setTimeout(300);

        try {
            $process->mustRun();

            BackupLog::create([
                'nama_file' => $uploaded->getClientOriginalName(),
                'jenis' => 'restore',
                'user_id' => auth()->id(),
                'status' => 'sukses',
                'keterangan' => 'Restore database berhasil dijalankan.',
            ]);

            return back()->with('success', 'Restore database berhasil dijalankan.');
        } catch (\Throwable $e) {
            BackupLog::create([
                'nama_file' => $uploaded->getClientOriginalName(),
                'jenis' => 'restore',
                'user_id' => auth()->id(),
                'status' => 'gagal',
                'keterangan' => $e->getMessage(),
            ]);

            return back()->with('error', 'Restore gagal. Pastikan mysql client tersedia di PATH sistem anda. Detail: ' . $e->getMessage());
        }
    }
}
