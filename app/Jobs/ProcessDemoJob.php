<?php

namespace App\Jobs;

use App\Models\JobRun;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class ProcessDemoJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 1;
    public int $timeour = 60;

    

    /**
     * Create a new job instance.
     */
    public function __construct(public int $jobRunId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobRun = JobRun::findOrFail($this->jobRunId);

        // Step 1: Job started
        $jobRun->update([
            'status' => 'running',
            'started_at' => now(),
            'error_message' => null,
        ]);

        // Step 2: Simulate a long-running process
        sleep(20);

         // Step 3: Job finished successfully
        $jobRun->update([
            'status' => 'finished',
            'finished_at' => now(),
        ]);
    }

    public function failed(?Throwable $exception): void
    {
        JobRun::whereKey($this->jobRunId)->update([
            'status' => 'failed',
            'finished_at' => now(),
            'error_message' => $exception?->getMessage(),
        ]);
    }
}
