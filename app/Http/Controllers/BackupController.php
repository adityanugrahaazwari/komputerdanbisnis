<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupController extends Controller
{
    public function index()
    {
        $this->authorizePermission('backups_view');
        
        $backupPath = 'backups';
        if (!Storage::disk('local')->exists($backupPath)) {
            Storage::disk('local')->makeDirectory($backupPath);
        }

        $files = Storage::disk('local')->files($backupPath);
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'size' => $this->formatBytes(Storage::disk('local')->size($file)),
                'date' => date('d M Y H:i:s', Storage::disk('local')->lastModified($file)),
                'path' => $file
            ];
        }

        // Sort backups by date descending
        usort($backups, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return view('backups.index', compact('backups'));
    }

    public function create()
    {
        $this->authorizePermission('backups_create');

        $dbHost = config('database.connections.mysql.host');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        
        $filename = "backup-" . date('Y-m-d-H-i-s') . ".sql";
        $storagePath = storage_path("app/backups");
        
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $filePath = $storagePath . DIRECTORY_SEPARATOR . $filename;

        // Command for mysqldump
        // We use --user, --password (with caution), and the database name
        // Note: mysqldump must be in the system path (which it usually is in Laragon)
        $command = sprintf(
            'mysqldump --user=%s %s %s > %s',
            escapeshellarg($dbUser),
            $dbPass ? '--password=' . escapeshellarg($dbPass) : '',
            escapeshellarg($dbName),
            escapeshellarg($filePath)
        );

        try {
            exec($command, $output, $returnVar);
            
            if ($returnVar !== 0) {
                return redirect()->back()->with('error', 'Gagal membuat backup database. Pastikan mysqldump terinstal.');
            }

            return redirect()->back()->with('success', 'Backup database berhasil dibuat: ' . $filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $this->authorizePermission('backups_view');
        $path = 'backups/' . $filename;

        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->download($path);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    public function destroy($filename)
    {
        $this->authorizePermission('backups_delete');
        $path = 'backups/' . $filename;

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
            return redirect()->back()->with('success', 'File backup berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
