<x-layouts::app :title="__('Todo quick List')">

    <!-- Card: Task List -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Task List</h2>
         <h2 class="text-xl font-bold text-gray-900 mb-4"><a href="{{ route('task-quick-add') }}">Add New task</a></h2>
        <ul id="task-list" class="divide-y divide-gray-100">
            <!-- Tasks will be inserted here -->

            @forelse ($tasks as $task)
            <li class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="space-y-1">
                    <h3 class="text-base font-semibold text-gray-900">{{ $task->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $task->description }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full border ${statusBadges[task.status]}">
                        {{ $task->status }}
                    </span>
                    
                    <button class="text-xs text-red-600 hover:text-red-800 font-medium cursor-pointer">
                        Delete
                    </button>
                </div>
            </li>
            @empty
            <p id="empty-state" class="text-sm text-gray-500 text-center py-6">No tasks added yet.</p>
            @endforelse

        </ul>

    </div>

</x-layouts::app>