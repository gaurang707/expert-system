<?php

namespace App\Services;

use App\Models\CsvImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class ImportCsvService
{
    public function importFromPath(string $filePath, int $importId): void
    {
        $startTime = microtime(true);
        $csvimport = CsvImport::findOrFail($importId);

        $chunkSize = 100;
        $chunk = [];
        $chunkEmails = [];

        $rowNumber = 1;
        $insertedCount = 0;
        $failedCount = 0;
        $totalRows = 0;
        $handle = null;

        $csvimport->update([
            'status' => 'processing',
            'started_at' => now(),
            'completed_at' => null,
            'error_message' => null,
        ]);

        try {
            $hashPassword = Hash::make('password');
            $handle = fopen($filePath, 'r');

            if ($handle === false) {
                throw new RuntimeException('Unable to open CSV file.');
            }

            $headers = fgetcsv($handle, escape: '\\');

            if ($headers === false) {
                throw new RuntimeException('CSV file is empty.');
            }

            $headers = array_map(
                fn ($header) => strtolower(
                    trim(ltrim((string) $header, "\xEF\xBB\xBF"))
                ),
                $headers
            );

            $requiredHeaders = ['name', 'email', 'status'];

            if (array_diff($requiredHeaders, $headers)) {
                throw new RuntimeException('Invalid CSV headers.');
            }

            // Count data rows before processing.
            while (fgetcsv($handle, escape: '\\') !== false) {
                $totalRows++;
            }

            $csvimport->update([
                'total_rows' => $totalRows,
            ]);

            // Return to the beginning and skip the header.
            if (!rewind($handle)) {
                throw new RuntimeException('Unable to rewind CSV file.');
            }

            fgetcsv($handle, escape: '\\');

            Log::info('CSV Import Started', [
                'file' => basename($filePath),
                'chunk_size' => $chunkSize,
                'total_rows' => $totalRows,
            ]);

            while (($row = fgetcsv($handle, escape: '\\')) !== false) {
                $processedRows = $rowNumber - 1;

                // Commit the previous batch before processing this row.
                // Rejected rows also count toward the batch size.
                if ($processedRows > 0 && $processedRows % $chunkSize === 0) {
                    $insertedCount = DB::transaction(function () use (
                        $chunk,
                        $insertedCount,
                        $failedCount,
                        $processedRows,
                        $csvimport
                    ) {
                        if (!empty($chunk)) {
                            DB::table('users')->insert($chunk);

                            $insertedCount += count($chunk);
                        }

                        $csvimport->update([
                            'processed_rows' => $processedRows,
                            'success_rows' => $insertedCount,
                            'failed_rows' => $failedCount,
                        ]);

                        return $insertedCount;
                    });

                    Log::info('CSV Import Progress', [
                        'processed_rows' => $processedRows,
                        'inserted' => $insertedCount,
                        'failed' => $failedCount,
                    ]);

                    $chunk = [];
                    $chunkEmails = [];
                }

                $rowNumber++;

                if (count($row) !== count($headers)) {
                    $failedCount++;

                    Log::warning('CSV Invalid Column Count', [
                        'row_number' => $rowNumber,
                    ]);

                    continue;
                }

                $data = array_combine($headers, $row);

                // Existing local testing behavior.
                // if (app()->environment('local')) {
                //     $data['email'] = 'test_'
                //         . Str::random(12)
                //         . '_'
                //         . $data['email'];
                // }

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
            }

            $processedRows = $rowNumber - 1;

            // Save the final batch and completion status together.
            $insertedCount = DB::transaction(function () use (
                $chunk,
                $insertedCount,
                $failedCount,
                $processedRows,
                $csvimport
            ) {
                if (!empty($chunk)) {
                    DB::table('users')->insert($chunk);

                    $insertedCount += count($chunk);
                }

                $csvimport->update([
                    'status' => 'completed',
                    'processed_rows' => $processedRows,
                    'success_rows' => $insertedCount,
                    'failed_rows' => $failedCount,
                    'completed_at' => now(),
                ]);

                return $insertedCount;
            });

            Log::info('CSV Import Completed', [
                'total_rows' => $totalRows,
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
        } catch (Throwable $exception) {
            $csvimport->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
                'completed_at' => now(),
            ]);

            throw $exception;
        } finally {
            if (is_resource($handle)) {
                fclose($handle);
            }
        }
    }
}