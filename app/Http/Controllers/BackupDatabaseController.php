<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\BackupDatabaseJob;
use App\Jobs\RestoreDatabaseJob;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class BackupDatabaseController extends Controller
{
    public function index()
    {
        $backupFolder = storage_path('backups'); // Update path if needed
        $files = File::allFiles($backupFolder);

        $fileList = [];
        foreach ($files as $file) {
            $fileList[] = [
                'name' => $file->getFilename(),
                'size' => $file->getSize(),
                'modified' => date('Y-m-d H:i:s', $file->getMTime()),
            ];
        }

        $files = collect($fileList)->sortByDesc('modified');
        return view('tools.backup_db', compact('files'));
    }


    public function generate()
    {
        try {
            BackupDatabaseJob::dispatch();
            sleep(5);
            return response()->json([
                'status'  => 'success',
                'message' => "Successfully created the backup file",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function restore_from_file(Request $request)
    {
        try {
            $backupFile = $request->file('database');
            $storagePath = storage_path('backups');
            $fileName = time() . '-' . $backupFile->getClientOriginalName();
            $permanentFilePath = $storagePath . $fileName;
            $backupFile->move($storagePath, $fileName);

            Log::info('Dropping all existing tables...');
            RestoreDatabaseJob::dispatch($permanentFilePath);

        } catch (\Exception $e) {
            Log::error('Error during database restore: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to restore the database.'], 500);
        }
    }

    public function destroy(Request $request)
    {
        $backupFolder = storage_path('backups');
        $fileName = $request->input('file_name');
        $filePath = $backupFolder . DIRECTORY_SEPARATOR . $fileName;

        if (File::exists($filePath)) {
            File::delete($filePath);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully deleted the backup file',
                'path'    => $filePath,
            ], 200);
        } else {

            return response()->json([
                'status'  => 'error',
                'message' => 'File not found',
            ], 500);
        }
    }

    public function restore(Request $request)
    {
        try {
            $backupFolder = storage_path('backups');
            $backupFile = $request->input('file_name');
            $permanentFilePath = $backupFolder . DIRECTORY_SEPARATOR . $backupFile;

            RestoreDatabaseJob::dispatch($permanentFilePath);
            sleep(5);
            return response()->json([
                'status'  => 'success',
                'message' => "Successfully restored the database",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
