<x-layouts::app :title="__('Todo - Create new task')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl border border-slate-100 bg-white p-6 shadow-sm max-w-xl mx-auto">
        <div class="space-y-4 max-w-xl mx-auto my-4">
            {{-- Success Message --}}
            @if (session('success'))
            <div class="flex items-start justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm">
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

            {{-- Custom Session Error Message --}}
            @if (session('error'))
            <div class="flex items-start justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold">Error</p>
                        <p class="text-sm text-rose-700">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @endif
            {{-- Validation Errors Bag --}}
            @if ($errors->any())
            <div class="flex items-start justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold">Please fix the following errors:</p>
                        <ul class="mt-1 list-disc list-inside text-sm text-rose-700 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @endif
        </div>

        <div>
            <a href="{{ route('tasks.index') }}">Todo List</a>
        </div>

        <!-- Card: Create Task Form -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Create quick New Task</h2>
            <form id="task-form" action="{{ route('tasks.store') }}" class="space-y-4" method="post">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Task Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g., Update documentation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition" />

                    @error('name')
                    <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Provide additional details..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition">{{ old('description') }}</textarea>

                    @error('description')
                    <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    @php                        
                        $status = old('status', 'pending');
                    @endphp
                    <select
                        name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition">
                        
                        <option value="pending" @if($status=='pending') selected @endif>Pending</option>
                        <option value="inprogress"  @if($status=='inprogress') selected @endif>In Progress</option>
                        <option value="completed"  @if($status=='completed') selected @endif>Completed</option>

                    </select>

                    @error('status')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 bg-black hover:bg-neutral-800 text-white text-sm font-medium rounded-lg transition duration-150 cursor-pointer">
                    Add Task
                </button>
            </form>
        </div>
    </div>
</x-layouts::app>