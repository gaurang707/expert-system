<x-layouts::app :title="__('Todo List')">

    @if (session('success'))
    <div class="flex items-start justify-between p-4 mb-2 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <div>
                <p class="text-sm font-semibold">Success</p>
                <p class="text-sm text-emerald-700">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    @endif
    <!-- Card: Task List -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Task List</h2>
        <a href="{{ route('tasks.create') }}">Add New task</a>
        <ul id="task-list" class="divide-y divide-gray-100">
            <!-- Tasks will be inserted here -->

            @forelse ($tasks as $task)
            <li class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="space-y-1">
                    <p class="text-base font-semibold text-gray-900">{{ $task->id }}</p>
                    
                </div>
                <div class="space-y-1">
                    <h3 class="text-base font-semibold text-gray-900">{{ $task->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $task->description }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full border ${statusBadges[task.status]}">
                        {{ $task->status }}
                    </span>

                    <a class="text-xs text-violet-600 hover:text-violet-800 font-medium cursor-pointer" href="{{ route('tasks.show', $task)}}">
                        Show
                    </a>
                    <a class="text-xs text-blue-600 hover:text-blue-800 font-medium cursor-pointer" href="{{ route('tasks.edit', $task)}}">
                        Edit
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium cursor-pointer">
                            Delete
                        </button>
                    </form>


                </div>
            </li>
            @empty
            <p id="empty-state" class="text-sm text-gray-500 text-center py-6">No tasks added yet.</p>
            @endforelse

        </ul>

    </div>

</x-layouts::app>