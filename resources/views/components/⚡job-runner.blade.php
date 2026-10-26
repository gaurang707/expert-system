<?php

use App\Jobs\TestJob;
use App\Models\ActionJob;
use Illuminate\Notifications\Action;
use Livewire\Component;

new class extends Component
{
    public function triggerJob(): void
    {
        $newJob = ActionJob::create([
            'job_hash' => str()->random(8),
            'status' => 'queued'
        ]);

        TestJob::dispatch($newJob)
            ->delay(now()->addSeconds(3));
    }

    public function with(): array
    {
        return [
            'jobs' => ActionJob::query()
                ->latest('id')
                ->limit(10)
                ->get(),
        ];
    }
};
?>

<div>
    {{-- It is never too late to be what you might have been. - George Eliot --}}


    <div
        class="min-h-screen bg-slate-950 px-6 py-12"
        wire:poll.1s>
        <div class="mx-auto max-w-5xl">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white">
                    Laravel Job Runner
                </h1>

                <p class="mt-2 text-sm text-slate-400">
                    Trigger queued jobs and watch their status update live.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900 shadow-xl">

                <div class="flex items-center justify-between border-b border-slate-800 px-6 py-5">

                    <div>
                        <h2 class="text-lg font-semibold text-white">
                            Job Queue
                        </h2>

                        <p class="mt-1 text-sm text-slate-400">
                            Click the button to dispatch a new background job.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="triggerJob"
                        wire:loading.attr="disabled"
                        wire:target="triggerJob"
                        class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-60">
                        <span
                            wire:loading.remove
                            wire:target="triggerJob">
                            Perform Action
                        </span>

                        <span
                            wire:loading
                            wire:target="triggerJob"
                            class="flex items-center gap-2">
                            <svg
                                class="h-4 w-4 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none">
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"></circle>

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>

                            Creating...
                        </span>
                    </button>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-slate-950/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Job
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Performed At
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-800">

                            @forelse ($jobs as $job)

                            <tr class="transition hover:bg-slate-800/50">

                                <td class="px-6 py-4">
                                    <div class="font-mono text-sm font-semibold text-slate-200">
                                        {{ $job->job_hash }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">

                                    @if ($job->status === 'queued')

                                    <span class="inline-flex rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-400">
                                        Queued
                                    </span>

                                    @elseif ($job->status === 'running')

                                    <span class="inline-flex items-center gap-2 rounded-full bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-400">

                                        <span class="h-2 w-2 animate-pulse rounded-full bg-blue-400"></span>

                                        Running
                                    </span>

                                    @elseif ($job->status === 'finished')

                                    <span class="inline-flex rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-400">
                                        Finished
                                    </span>

                                    @else

                                    <span class="inline-flex rounded-full bg-slate-700 px-3 py-1 text-xs font-semibold text-slate-300">
                                        {{ ucfirst($job->status) }}
                                    </span>

                                    @endif

                                </td>

                                <td class="px-6 py-4 text-sm text-slate-400">
                                    {{ $job->created_at->format('d M Y, h:i:s A') }}
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td
                                    colspan="3"
                                    class="px-6 py-12 text-center">
                                    <div class="text-sm text-slate-500">
                                        No jobs have been triggered yet.
                                    </div>
                                </td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>



</div>