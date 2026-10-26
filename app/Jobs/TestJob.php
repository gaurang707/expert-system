<?php

namespace App\Jobs;

use App\Models\ActionJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TestJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public ActionJob $theJob)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->theJob->update([
            'status' => 'running'
        ]);

        // Simulate some background work.
        sleep(4);

         $this->theJob->update([
            'status' => 'finished',
        ]);
    }
}
