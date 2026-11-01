<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskquickRequest;
use App\Http\Requests\UpdateTaskRequest;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{        

    /**
     * Display a listing of the resource.
     */
    public function index_quick()
    {
        $tasks = Task::select('id', 'name', 'description', 'status')->get();
        return view('basic.tasks.index_quick', compact('tasks'));
    }

    public function todoQuickAdd() 
    {
        return view('basic.tasks.quick_todo_add');
    }

    public function todoQuickStore(TaskquickRequest $request) 
    {
       $validated = $request->validated();
       $validated['user_id'] = auth()->user()->id;

       try {
        Task::create($validated);
        return redirect()
                ->route('task-list')
                ->with('success', 'Task added succefully');
       } catch (Exception $e) {
            logger()->error('Task added successfully: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again later.');
       }
    }

    public function index() 
    {
        $tasks = Task::latest()->paginate(10);
        return view('basic.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('basic.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();        
        $validated['user_id'] = auth()->user()->id;
        Task::create($validated);
        return  redirect()->route('tasks.index')->with('success', 'New task added succefully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('basic.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('basic.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {

        $validated = $request->validated();

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
