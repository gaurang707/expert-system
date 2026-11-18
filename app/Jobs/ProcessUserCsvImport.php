<?php

namespace App\Jobs;

use App\Services\ImportCsvService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ProcessUserCsvImport implements ShouldQueue
{
    use Queueable;
    public int $tries = 1;

    public int $timeout = 240;


    /**
     * Create a new job instance.
     */
    public function __construct(public string $filePath)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ImportCsvService $importService): void
    {
         $fullPath = Storage::disk('local')
            ->path($this->filePath);

         // Method to implement using your existing import logic.        

        $importService->importFromPath($fullPath);

         // Delete only after successful processing.
        Storage::disk('local')->delete($this->filePath);
    }
}
