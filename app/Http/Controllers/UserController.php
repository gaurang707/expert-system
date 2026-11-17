<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkUserActionRequest;
use App\Models\User;
use App\Services\BulkUserActionService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected BulkUserActionService $bulkAction) {}

    public function bulkActionIndex(Request $request)
    {
        $users = User::withTrashed()
            ->select('id', 'name', 'email', 'status', 'created_at', 'deleted_at')
            ->with('roles:id,name')
            ->paginate(50);

        return view('inter.users.bulk-action', compact('users'));
    }

    public function bulkActionPost(BulkUserActionRequest $request)
    {
        $validated = $request->validated();

        //check there is not any administrator level ID
        $user_ids = $validated['user_ids'];

        $users = User::select('id')
            ->with('roles:id,name')
            ->whereIn('id', $user_ids)
            ->get();

        $protectedIds = $users
            ->filter(fn($user) => $user->roles->contains('id', 1))
            ->pluck('id')
            ->all();


        if (!empty($protectedIds)) {
            return back()->with([
                'error' => 'Operation rejected. Super Admin users are protected.',
                'bulk_results' => $users->map(function ($user) {
                    $isSuperAdmin = $user->roles->contains('id', 1);

                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'status' => $isSuperAdmin
                            ? 'Super Admin (protected)'
                            : 'Valid',
                    ];
                })->values()->all(),
            ]);
        }

        $affectedCount =  $this->bulkAction->todoBulkAction($validated);
        $action = $validated['action'];

        $message = match ($action) {
            'activate' => "{$affectedCount} users activated successfully.",
            'deactivate' => "{$affectedCount} users deactivated successfully.",
            'delete' => "{$affectedCount} users deleted successfully.",
        };

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
