<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
        'search' => ['nullable', 'string', 'min:3', 'max:100'],
        'role_id' => ['nullable', 'integer', 'exists:roles,id'],
        'status' => ['nullable', 'in:active,inactive'],
        'date_from' => ['nullable', 'date_format:Y-m-d'],
        'date_to' => [
            'nullable',
            'date_format:Y-m-d',
            'after_or_equal:date_from',
        ],
        'per_page' => ['nullable', 'integer', 'in:10,25,50,100'],
    ]); 

        $users = User::query()
        ->with('role')
        ->filter($filters)
        ->latest()
        ->paginate((int) ($filters['per_page'] ?? 10))
        ->withQueryString();

        $roles = Role::select('id', 'display_name')
            ->orderBy('display_name', 'asc')
            ->get();

        return view('basic.users.index', compact('users', 'roles', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('id', 'display_name')
            ->orderBy('display_name', 'asc')
            ->get();
        return view('basic.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] =  Hash::make($validated['password']);
        User::create($validated);
        return redirect()->route('users.index')->with('success', 'Users created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('basic.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::select('id', 'display_name')
            ->orderBy('display_name', 'asc')
            ->get();
        return view('basic.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'Uset updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role_id == 2) {
            return redirect()->route('users.index')->with('error', 'Administator cannot be deleted');
            exit;
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function updateeditmodal(User $user)
    {
        //
    }

    public function updatemodal(UpdateUserRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'role_name' => $user->role?->display_name ?? 'N/A',
            ],
        ]);
    }
}
