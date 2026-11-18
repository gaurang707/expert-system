<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportCsvService
{


    /**
     * Create a new class instance.
     */
    public function __construct() {}
    public function importFromPath(string $filePath): void
    {
        $startTime = microtime(true);

        $chunkSize = 100;
        $chunk = [];
        $chunkEmails = [];

        $rowNumber = 1;
        $insertedCount = 0;
        $failedCount = 0;

        // Hash only once, not for every user.
        $hashPassword = Hash::make('password');

        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            throw new \RuntimeException('Unable to open CSV file.');
        }

        Log::info('CSV Import Started', [
            'file' => basename($filePath),
            'chunk_size' => $chunkSize,
        ]);

        try {
            $headers = fgetcsv($handle);

            if ($headers === false) {
                throw new \RuntimeException('CSV file is empty.');
            }

            $headers = array_map(
                fn($header) => strtolower(
                    trim(ltrim($header, "\xEF\xBB\xBF"))
                ),
                $headers
            );

            $requiredHeaders = ['name', 'email', 'status'];

            if (array_diff($requiredHeaders, $headers)) {
                throw new \RuntimeException('Invalid CSV headers.');
            }

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                // Validate column count.
                if (count($row) !== count($headers)) {
                    $failedCount++;

                    Log::warning('CSV Invalid Column Count', [
                        'row_number' => $rowNumber,
                    ]);

                    continue;
                }

                $data = array_combine($headers, $row);

               // Testing only: generate unique email values.
               // Remove this block for real customer imports.
                if (app()->environment('local')) {
                    $data['email'] = 'test_'
                        . Str::random(12)
                        . '_'
                        . $data['email'];
                }

                $validator = Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email',
                    'status' => 'required|in:active,inactive',
                ]);

                if ($validator->fails()) {
                    $failedCount++;

                    Log::warning('CSV Validation Failed', [
                        'row_number' => $rowNumber,
                        'errors' => $validator->errors()->toArray(),
                    ]);

                    continue;
                }

                // Prevent duplicates within the current chunk.
                $emailKey = strtolower($data['email']);

                if (isset($chunkEmails[$emailKey])) {
                    $failedCount++;

                    Log::warning('Duplicate Email Within Chunk', [
                        'row_number' => $rowNumber,
                    ]);

                    continue;
                }

                $chunkEmails[$emailKey] = true;

                $chunk[] = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'status' => $data['status'],
                    'password' => $hashPassword,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert when chunk reaches 100 records.
                if (count($chunk) >= $chunkSize) {
                    DB::table('users')->insert($chunk);

                    $insertedCount += count($chunk);

                    Log::info('CSV Chunk Inserted', [
                        'inserted_count' => $insertedCount,
                        'last_row_number' => $rowNumber,
                        'elapsed_seconds' => round(
                            microtime(true) - $startTime,
                            2
                        ),
                    ]);

                    // Clear chunk after successful insertion.
                    $chunk = [];
                    $chunkEmails = [];
                }
            }

            // Insert remaining records (fewer than 100).
            if (!empty($chunk)) {
                DB::table('users')->insert($chunk);

                $insertedCount += count($chunk);
            }

            Log::info('CSV Import Completed', [
                'total_rows' => $rowNumber - 1,
                'inserted' => $insertedCount,
                'failed' => $failedCount,
                'execution_seconds' => round(
                    microtime(true) - $startTime,
                    2
                ),
                'peak_memory_mb' => round(
                    memory_get_peak_usage(true) / 1048576,
                    2
                ),
            ]);
        } finally {
            fclose($handle);
        }
    }
}
