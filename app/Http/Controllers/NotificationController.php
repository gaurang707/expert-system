<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'filter' => ['nullable', 'in:all,unread,read'],
        ]);

        $filter = $request->query('filter', 'all');
        $user = $request->user();


        $notifications = $user->notifications()
            ->when($filter === 'unread', function ($query) {
                $query->whereNull('read_at');
            })
            ->when($filter === 'read', function ($query) {
                $query->whereNotNull('read_at');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $unreadCount = $user->unreadNotifications()->count();

        return view('inter.admin.notification', compact(
            'notifications',
            'unreadCount',
            'filter'
        ));
    }

    public function toggleRead(Request $request, string $id)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        if ($notification->read_at === null) {
            $notification->markAsRead();
        } else {
            $notification->markAsUnread();
        }

        return back()->with(
            'success',
            'Notification status updated successfully.'
        );
    }

    public function markAllRead(Request $request)
    {
        $request->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return back()->with(
            'success',
            'All notifications marked as read.'
        );
    }

    public function destroy(Request $request, string $id)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        return back()->with(
            'success',
            'Notification deleted successfully.'
        );
    }
}
