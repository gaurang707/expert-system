<x-layouts::app :title="__('Todo List')">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">

         <div>
            <a href="{{ route('tasks.index') }}">Todo List</a>
        </div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">Task Details</h2>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1"><strong>Task Name : </strong> {{ $task->name }}</label>            
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1"><strong> Description : </strong>{{ $task->description }} </label>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1"><strong>Status : </strong>
               {{ $task->status }}</label>
        </div>

        </form>
    </div>
</x-layouts::app>