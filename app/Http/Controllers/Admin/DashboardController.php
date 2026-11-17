<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\DashboardStatsService;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(public DashboardStatsService $dashStatservice) {}
    public function index()
    {
        $userTotal = User::withTrashed()->count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $deletedUsers = User::onlyTrashed()->count();

        $roleTotal = Role::count();
        $roles = Role::withCount('users')->get(['id', 'name']);

        $rolePerceByUser = [];
        foreach ($roles  as $role) {

            $perc = $userTotal > 0
                ? round(($role->users_count * 100) / $userTotal, 2)
                : 0;

            $rolePerceByUser[$role->id] = $perc;
        }

        $registeredThisMonth =  User::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ])->count();

        $activeusersPercentage = $userTotal > 0
            ? round(($activeUsers / $userTotal) * 100, 2)
            : 0;

        $inactiveusersPercentage = $userTotal > 0
            ? round(($inactiveUsers / $userTotal) * 100, 2)
            : 0;

        $registeredThisMonthPercentage = $userTotal > 0
            ? round(($registeredThisMonth / $userTotal) * 100, 2)
            : 0;

        $deletedUsersPercentage = $userTotal > 0
            ? round(($deletedUsers / $userTotal) * 100, 2)
            : 0;

        $recentlyRegiUsers = User::withTrashed()->latest()
            ->take(5)
            ->get(['id', 'name', 'email', 'status', 'created_at']);            

        $states = [
            'userTotal' => $userTotal,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'deletedUsers' => $deletedUsers,
            'roleTotal' => $roleTotal,
            'registeredThisMonth' => $registeredThisMonth,
            'activeusersPercentage' => $activeusersPercentage,
            'inactiveusersPercentage' => $inactiveusersPercentage,
            'registeredThisMonthPercentage' => $registeredThisMonthPercentage,
            'deletedUsersPercentage' => $deletedUsersPercentage,
            'roles' => $roles,
            'rolePerceByUser' => $rolePerceByUser,
            'recentlyRegiUsers' => $recentlyRegiUsers,
        ];

        return view('admin.dashboard', compact('states'));
    }
}
