<x-layouts::app :title="__('Job Runner')">

    <div class="max-w-6xl mx-auto px-4 py-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Background Job Runner
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Dispatch jobs and monitor their status.
                </p>
            </div>

            <form method="POST"
                action="{{ route('job-runner.store') }}">
                @csrf

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white
                       rounded-lg hover:bg-blue-700">
                    Dispatch New Job
                </button>
            </form>
        </div>

        <!-- Success -->
        @if(session('success'))
        <div class="mb-5 p-4 bg-green-50 text-green-800
                    rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
        @endif

        <!-- Refresh -->
        <div class="flex justify-between items-center mb-4">
            <p class="text-sm text-gray-500">
                Refresh the page to check latest job statuses.
            </p>

            <a href="{{ route('job-runner.index') }}"
                class="px-4 py-2 border border-gray-300
                  rounded-lg hover:bg-gray-50">
                Refresh Status
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white border
                border-gray-200 rounded-xl">

            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-4">Job ID</th>
                        <th class="p-4">Job Name</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Started</th>
                        <th class="p-4">Finished</th>
                        <th class="p-4">Notes</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($jobRuns as $job)
                    <tr>
                        <td class="p-4">
                            #{{ $job->id }}
                        </td>

                        <td class="p-4 font-medium">
                            {{ $job->name }}
                        </td>

                        <td class="p-4">
                            @php
                            $statusClasses = match($job->status) {
                            'queued' => 'bg-yellow-100 text-yellow-800',
                            'running' => 'bg-blue-100 text-blue-800',
                            'finished' => 'bg-green-100 text-green-800',
                            'failed' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-700',
                            };
                            @endphp

                            <span class="px-3 py-1 rounded-full
                                         text-xs font-semibold
                                         {{ $statusClasses }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>

                        <td class="p-4">
                            {{ $job->started_at?->format('M d, Y h:i A') ?? '-' }}
                        </td>

                        <td class="p-4">
                            {{ $job->finished_at?->format('M d, Y h:i A') ?? '-' }}
                        </td>

                        <td class="p-4 text-gray-500">
                            {{ $job->error_message
                                ? \Illuminate\Support\Str::limit($job->error_message, 80)
                                : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6"
                            class="p-8 text-center text-gray-500">
                            No jobs dispatched yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $jobRuns->links() }}
        </div>

    </div>
</x-layouts::app>