<?php

namespace App\Http\Controllers;

use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    protected string $backupPath = 'app/backups';

    protected string $mysqlBin = 'C:\\xampp\\mysql\\bin';

    public function index()
    {
        $dir = storage_path($this->backupPath);

        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $files = collect(File::files($dir))
            ->sortByDesc(fn ($f) => $f->getMTime())
            ->map(fn ($f) => [
                'nama' => $f->getFilename(),
                'ukuran' => round($f->getSize() / 1024, 2) . ' KB',
                'tanggal' => date('d-m-Y H:i:s', $f->getMTime()),
            ]);

        $logs = BackupLog::with('user')
            ->latest()
            ->take(20)
            ->get();

        return view('backup.index', compact('files', 'logs'));
    }

    /**
     * BACKUP DATABASE
     */
    public function backup(Request $request)
    {
        $dir = storage_path($this->backupPath);

        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $db = config('database.connections.mysql');

        $filename = 'backup-' .
            $db['database'] .
            '-' .
            now()->format('Ymd_His') .
            '.sql';

        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $mysqldump = $this->mysqlBin . '\\mysqldump.exe';

        try {

            /*
             * Pastikan mysqldump ada.
             */
            if (!File::exists($mysqldump)) {
                throw new \Exception(
                    'mysqldump.exe tidak ditemukan: ' . $mysqldump
                );
            }

            /*
             * Ambil konfigurasi database.
             */
            $host = $db['host'] ?: '127.0.0.1';
            $port = $db['port'] ?: 3306;
            $username = $db['username'];
            $password = $db['password'] ?? '';
            $database = $db['database'];

            /*
             * Escape untuk CMD Windows.
             */
            $mysqldumpEscaped = '"' . $mysqldump . '"';

            /*
             * Password.
             */
            $passwordOption = '';

            if ($password !== '') {
                $passwordOption = ' -p' . escapeshellarg($password);
            }

            /*
             * Command yang sama seperti command
             * yang terbukti berhasil di PowerShell.
             */
            $command =
                $mysqldumpEscaped .
                ' -h ' . escapeshellarg($host) .
                ' -P ' . escapeshellarg((string) $port) .
                ' -u ' . escapeshellarg($username) .
                $passwordOption .
                ' ' . escapeshellarg($database) .
                ' > ' . escapeshellarg($filepath) .
                ' 2>&1';

            /*
             * Jalankan menggunakan CMD Windows.
             */
            $fullCommand = 'cmd.exe /C "' . $command . '"';

            $output = [];
            $exitCode = 0;

            exec($fullCommand, $output, $exitCode);

            /*
             * Jika gagal.
             */
            if ($exitCode !== 0) {

                if (File::exists($filepath)) {
                    File::delete($filepath);
                }

                $error = implode(PHP_EOL, $output);

                throw new \Exception(
                    'mysqldump gagal dengan kode ' .
                    $exitCode .
                    ($error ? ': ' . $error : '')
                );
            }

            /*
             * Pastikan file dibuat.
             */
            if (!File::exists($filepath)) {
                throw new \Exception(
                    'File backup tidak berhasil dibuat.'
                );
            }

            /*
             * Pastikan file tidak kosong.
             */
            if (File::size($filepath) <= 0) {

                File::delete($filepath);

                throw new \Exception(
                    'File backup kosong.'
                );
            }

            /*
             * Simpan log sukses.
             */
            BackupLog::create([
                'nama_file' => $filename,
                'jenis' => 'backup',
                'user_id' => auth()->id(),
                'status' => 'sukses',
                'keterangan' => 'Backup database berhasil dibuat.',
            ]);

            return back()->with(
                'success',
                'Backup database berhasil dibuat: ' . $filename
            );

        } catch (\Throwable $e) {

            if (File::exists($filepath)) {
                File::delete($filepath);
            }

            BackupLog::create([
                'nama_file' => $filename,
                'jenis' => 'backup',
                'user_id' => auth()->id(),
                'status' => 'gagal',
                'keterangan' => $e->getMessage(),
            ]);

            return back()->with(
                'error',
                'Backup gagal: ' . $e->getMessage()
            );
        }
    }

    /**
     * DOWNLOAD BACKUP
     */
    public function download(string $filename)
    {
        $filename = basename($filename);

        $filepath = storage_path(
            $this->backupPath . DIRECTORY_SEPARATOR . $filename
        );

        abort_unless(File::exists($filepath), 404);

        return response()->download($filepath);
    }

    /**
     * DELETE BACKUP
     */
    public function destroy(string $filename)
    {
        $filename = basename($filename);

        $filepath = storage_path(
            $this->backupPath . DIRECTORY_SEPARATOR . $filename
        );

        if (File::exists($filepath)) {
            File::delete($filepath);
        }

        return back()->with(
            'success',
            'File backup berhasil dihapus.'
        );
    }

    /**
     * RESTORE DATABASE
     */
    public function restore(Request $request)
    {
        $request->validate([
            'file_restore' => 'required|file|mimes:sql,txt|max:51200',
        ]);

        $uploaded = $request->file('file_restore');

        $tmpPath = $uploaded->getRealPath();

        $db = config('database.connections.mysql');

        $mysql = $this->mysqlBin . '\\mysql.exe';

        try {

            if (!File::exists($mysql)) {
                throw new \Exception(
                    'mysql.exe tidak ditemukan: ' . $mysql
                );
            }

            if (!$tmpPath || !File::exists($tmpPath)) {
                throw new \Exception(
                    'File restore tidak ditemukan.'
                );
            }

            $host = $db['host'] ?: '127.0.0.1';
            $port = $db['port'] ?: 3306;
            $username = $db['username'];
            $password = $db['password'] ?? '';
            $database = $db['database'];

            $mysqlEscaped = '"' . $mysql . '"';

            $passwordOption = '';

            if ($password !== '') {
                $passwordOption = ' -p' . escapeshellarg($password);
            }

            /*
             * Restore menggunakan input file.
             */
            $command =
                $mysqlEscaped .
                ' -h ' . escapeshellarg($host) .
                ' -P ' . escapeshellarg((string) $port) .
                ' -u ' . escapeshellarg($username) .
                $passwordOption .
                ' ' . escapeshellarg($database) .
                ' < ' . escapeshellarg($tmpPath) .
                ' 2>&1';

            $fullCommand = 'cmd.exe /C "' . $command . '"';

            $output = [];
            $exitCode = 0;

            exec($fullCommand, $output, $exitCode);

            if ($exitCode !== 0) {

                $error = implode(PHP_EOL, $output);

                throw new \Exception(
                    'mysql restore gagal dengan kode ' .
                    $exitCode .
                    ($error ? ': ' . $error : '')
                );
            }

            BackupLog::create([
                'nama_file' => $uploaded->getClientOriginalName(),
                'jenis' => 'restore',
                'user_id' => auth()->id(),
                'status' => 'sukses',
                'keterangan' => 'Restore database berhasil dijalankan.',
            ]);

            return back()->with(
                'success',
                'Restore database berhasil dijalankan.'
            );

        } catch (\Throwable $e) {

            BackupLog::create([
                'nama_file' => $uploaded->getClientOriginalName(),
                'jenis' => 'restore',
                'user_id' => auth()->id(),
                'status' => 'gagal',
                'keterangan' => $e->getMessage(),
            ]);

            return back()->with(
                'error',
                'Restore gagal: ' . $e->getMessage()
            );
        }
    }
}