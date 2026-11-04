<x-layouts::app :title="__('Task Move')">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center
                justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Task Reordering
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Manage your tasks and change their display order.
            </p>
        </div>

        <span class="inline-flex items-center rounded-lg
                     bg-blue-50 text-blue-700 px-4 py-2
                     text-sm font-medium">
            Total Tasks: {{ $tasks->count() }}
        </span>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 rounded-lg border border-green-200
                    bg-green-50 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
    @endif

    <!-- Tasks Table -->
    <div class="overflow-x-auto rounded-xl border
                border-gray-200 bg-white shadow-sm">

        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr class="text-left text-xs font-semibold
                           uppercase tracking-wider text-gray-500">

                    <th class="px-6 py-4">Position</th>
                    <th class="px-6 py-4">Task Details</th>
                    <th class="px-6 py-4">Priority</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Move Up</th>
                    <th class="px-6 py-4 text-center">Move Down</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($tasks as $task)

                <tr class="hover:bg-gray-50 transition-colors">

                    <!-- Position -->
                    <td class="px-6 py-4">
                        <span class="inline-flex h-9 w-9
                                         items-center justify-center
                                         rounded-lg bg-gray-100
                                         text-sm font-semibold text-gray-700">
                            {{ $loop->iteration }}
                        </span>
                    </td>


                    <!-- Task -->
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ $task->name }}
                        </div>
                        <div class="mt-1 text-xs text-gray-400">
                            ID:
                            {{ $task->id }}
                        </div>

                        @if($task->description)
                        <div class="mt-1 text-xs text-gray-500">
                            {{ Str::limit($task->description, 80) }}
                        </div>
                        @endif

                        <div class="mt-1 text-xs text-gray-400">
                            Created:
                            {{ $task->created_at->format('M d, Y') }}
                        </div>
                    </td>

                    <!-- Priority -->
                    <td class="px-6 py-4">
                        @php
                        $priorityClass = match(
                        strtolower($task->priority ?? '')
                        ) {
                        'high' => 'bg-red-100 text-red-700',
                        'medium', 'normal' => 'bg-yellow-100 text-yellow-700',
                        'low' => 'bg-green-100 text-green-700',
                        default => 'bg-gray-100 text-gray-700'
                        };
                        @endphp

                        <span class="inline-flex rounded-full
                                         px-3 py-1 text-xs font-semibold
                                         {{ $priorityClass }}">
                            {{ ucfirst($task->priority ?? 'Normal') }}
                        </span>
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                        @php
                        $statusClass = match($task->status) {
                        'completed' => 'bg-green-100 text-green-700',
                        'inprogress', 'in_progress' => 'bg-blue-100 text-blue-700',
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'failed' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700'
                        };
                        @endphp

                        <span class="inline-flex rounded-full
                                         px-3 py-1 text-xs font-semibold
                                         {{ $statusClass }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </td>

                    <!-- Move Up -->
                    <td class="px-6 py-4 text-center">
                        <form method="POST"
                            action="{{ route('tasks.move', [$task, 'up']) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                @disabled($loop->first)
                                title="Move Up"
                                class="inline-flex h-9 w-9 items-center
                                justify-center rounded-lg border
                                border-gray-300 bg-white
                                text-gray-700 hover:bg-blue-50
                                hover:text-blue-700
                                disabled:opacity-30
                                disabled:cursor-not-allowed">
                                &uarr;
                            </button>
                        </form>
                    </td>

                    <!-- Move Down -->
                    <td class="px-6 py-4 text-center">
                        <form method="POST"
                            action="{{ route('tasks.move', [$task, 'down']) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                @disabled($loop->last)
                                title="Move Down"
                                class="inline-flex h-9 w-9 items-center
                                justify-center rounded-lg border
                                border-gray-300 bg-white
                                text-gray-700 hover:bg-blue-50
                                hover:text-blue-700
                                disabled:opacity-30
                                disabled:cursor-not-allowed">
                                &darr;
                            </button>
                        </form>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6"
                        class="px-6 py-16 text-center">

                        <p class="text-lg font-semibold text-gray-800">
                            No tasks found
                        </p>

                        <p class="mt-2 text-sm text-gray-500">
                            Create some tasks to start managing their order.
                        </p>

                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="mt-5 flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Showing {{ $tasks->count() }} tasks
        </p>

        <p class="text-xs text-gray-400">
            Use the arrow buttons to change task order.
        </p>
    </div>
</x-layouts::app>