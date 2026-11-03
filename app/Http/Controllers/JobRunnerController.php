<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDemoJob;
use App\Models\JobRun;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobRunnerController extends Controller
{
    public function index(): View
    {
         $jobRuns = JobRun::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('basic.job-runner.index', compact('jobRuns'));

    }

    public function store(): RedirectResponse
    {
        $jobRun = JobRun::create([
            'user_id' => Auth::id(),
            'name' => 'Generate Sample Report',
            'status' => 'queued',
        ]);

        ProcessDemoJob::dispatch($jobRun->id)
            ->onConnection('database')
            ->onQueue('demo-jobs')
            ->afterCommit();

        return redirect()
            ->route('job-runner.index')
            ->with('success', 'Job dispatched successfully.');
    }
}
