<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class RestoreDatabaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $filePath = $this->filePath;
        Log::info("Starting database restoration from file: {$filePath}");

        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');

        // Make sure the file exists before proceeding
        if (!file_exists($filePath)) {
            Log::error("Backup file does not exist: {$filePath}");
            return;
        }

        if (!empty($password)) {
            $command = [
                'mysql',
                '-h', $dbHost,
                '-P', $dbPort,
                '-u', $dbUser,
                '-p' . $dbPassword,
                $dbName,
                '-e', "source {$filePath}",
            ];
        } else {
            $command = [
                'mysql',
                '-h', $dbHost,
                '-P', $dbPort,
                '-u', $dbUser,
                $dbName,
                '-e', "source {$filePath}",
            ];
        }
        // Run the MySQL restore command using the backup file

        $process = new Process($command);
        $process->setTimeout(null); // No timeout

        $process->run(function ($type, $buffer) {
            if ($type === Process::ERR) {
                Log::error($buffer);
            } else {
                Log::info($buffer);
            }
        });

        if ($process->isSuccessful()) {
            return true;
            // Log::info('Database restored successfully.');
        } else {
            return false;
            // Log::error('Database restoration failed.');
        }
    }
}


