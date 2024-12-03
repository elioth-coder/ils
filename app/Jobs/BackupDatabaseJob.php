<?php

namespace App\Jobs;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class BackupDatabaseJob implements ShouldQueue
{
    use Queueable;
    /**
     * Execute the job.
     */
    public function handle()
    {
        // Database connection details
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        // Backup file path
        $backupFolder = 'backups';
        $filename = 'BACKUP_' . now()->format('Y_m_d_His') . '.sql';
        $filepath = storage_path("backups" . DIRECTORY_SEPARATOR . $filename);

        // Ensure the backup directory exists
        if (!Storage::exists($backupFolder)) {
            Storage::makeDirectory($backupFolder);
        }

        if (!empty($password)) {
            $command = "mysqldump --single-transaction --routines --triggers -u{$username} -p{$password} -h{$host} {$database} > \"{$filepath}\"";
        } else {
            $command = "mysqldump --single-transaction --routines --triggers -u{$username} -h{$host} {$database} > \"{$filepath}\"";
        }

        Log::info("Command: {$command}");
        Log::info("Starting database backup to file: {$filepath}");

        // Execute the command
        $process = Process::fromShellCommandline($command);
        $process->run();

        // Check command result
        if ($process->isSuccessful()) {
            $message = "Backup created successfully: {$filepath}";
            Log::info($message);
            return $filepath;
        } else {
            // If the command failed
            $message = "Backup failed: " . $process->getErrorOutput();
            Log::error($message);
            throw new Exception($message);
        }
    }
}
