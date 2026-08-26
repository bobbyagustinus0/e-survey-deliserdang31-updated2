<?php

namespace App\Http\Controllers;

use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    protected string $backupPath = 'app/backups';

    /**
     * Cari lokasi binary MySQL sesuai OS.
     *
     * Windows:
     * C:\xampp\mysql\bin\mysqldump.exe
     *
     * Linux/Railway:
     * mysqldump dari PATH
     */
    protected function getMysqlBinary(string $binary): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $paths = [
                'C:\\xampp\\mysql\\bin\\' . $binary . '.exe',
                'C:\\xampp\\mysql\\bin\\' . $binary,
                'C:\\laragon\\bin\\mysql\\mysql-8.0.30\\bin\\' . $binary . '.exe',
            ];

            foreach ($paths as $path) {
                if (File::exists($path)) {
                    return $path;
                }
            }

            throw new \Exception(
                $binary . '.exe tidak ditemukan. Pastikan MySQL/XAMPP tersedia.'
            );
        }

        // Linux / Railway
        $binaryPath = trim((string) shell_exec('command -v ' . escapeshellarg($binary)));

        if ($binaryPath !== '') {
            return $binaryPath;
        }

        throw new \Exception(
            $binary . ' tidak ditemukan di PATH server Railway.'
        );
    }

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

        try {
            $mysqldump = $this->getMysqlBinary('mysqldump');

            $host = $db['host'] ?: '127.0.0.1';
            $port = $db['port'] ?: 3306;
            $username = $db['username'];
            $password = $db['password'] ?? '';
            $database = $db['database'];

            /*
             * Gunakan environment OS.
             */
            if (PHP_OS_FAMILY === 'Windows') {
                $passwordOption = '';

                if ($password !== '') {
                    $passwordOption = ' -p' . escapeshellarg($password);
                }

                $command =
                    '"' . $mysqldump . '"' .
                    ' -h ' . escapeshellarg($host) .
                    ' -P ' . escapeshellarg((string) $port) .
                    ' -u ' . escapeshellarg($username) .
                    $passwordOption .
                    ' ' . escapeshellarg($database) .
                    ' > ' . escapeshellarg($filepath) .
                    ' 2>&1';

                $fullCommand = 'cmd.exe /C "' . $command . '"';
            } else {
                /*
                 * Linux / Railway
                 */
                $passwordOption = '';

                if ($password !== '') {
                    $passwordOption = ' --password=' . escapeshellarg($password);
                }

                $command =
                    escapeshellarg($mysqldump) .
                    ' -h ' . escapeshellarg($host) .
                    ' -P ' . escapeshellarg((string) $port) .
                    ' -u ' . escapeshellarg($username) .
                    $passwordOption .
                    ' ' . escapeshellarg($database) .
                    ' > ' . escapeshellarg($filepath) .
                    ' 2>&1';

                $fullCommand = $command;
            }

            $output = [];
            $exitCode = 0;

            exec($fullCommand, $output, $exitCode);

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

            if (!File::exists($filepath)) {
                throw new \Exception(
                    'File backup tidak berhasil dibuat.'
                );
            }

            if (File::size($filepath) <= 0) {

                File::delete($filepath);

                throw new \Exception(
                    'File backup kosong.'
                );
            }

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

        try {
            $mysql = $this->getMysqlBinary('mysql');

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

            if (PHP_OS_FAMILY === 'Windows') {

                $passwordOption = '';

                if ($password !== '') {
                    $passwordOption = ' -p' . escapeshellarg($password);
                }

                $command =
                    '"' . $mysql . '"' .
                    ' -h ' . escapeshellarg($host) .
                    ' -P ' . escapeshellarg((string) $port) .
                    ' -u ' . escapeshellarg($username) .
                    $passwordOption .
                    ' ' . escapeshellarg($database) .
                    ' < ' . escapeshellarg($tmpPath) .
                    ' 2>&1';

                $fullCommand = 'cmd.exe /C "' . $command . '"';

            } else {

                /*
                 * Linux / Railway
                 */
                $passwordOption = '';

                if ($password !== '') {
                    $passwordOption =
                        ' --password=' . escapeshellarg($password);
                }

                $command =
                    escapeshellarg($mysql) .
                    ' -h ' . escapeshellarg($host) .
                    ' -P ' . escapeshellarg((string) $port) .
                    ' -u ' . escapeshellarg($username) .
                    $passwordOption .
                    ' ' . escapeshellarg($database) .
                    ' < ' . escapeshellarg($tmpPath) .
                    ' 2>&1';

                $fullCommand = $command;
            }

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