<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\UserStatusNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use InvalidArgumentException;

class BulkUserActionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function todoBulkAction(array $data)
    {

        $action = trim($data['action']);

        $userIds = $data['user_ids'];

        $result = DB::transaction(function () use ($userIds, $action) {


            // Soft-delete selected users
            if ($action === 'delete') {

                $changedUserIds = User::whereIn('id', $userIds)
                    ->pluck('id')
                    ->all();

                return [
                    'count' => User::whereIn('id', $userIds)->delete(),
                    'user_ids' => $changedUserIds,
                ];
            }

            $status = match ($action) {
                'activate' => 'active',
                'deactivate' => 'inactive',
                default => throw new InvalidArgumentException(
                    'Invalid bulk action.'
                ),
            };

            // Select users whose status needs to change
            $changedUserIds = User::whereIn('id', $userIds)
                ->where('status', '!=', $status)
                ->pluck('id')
                ->all();

            // Bulk update
            $updatedCount = User::whereIn('id', $changedUserIds)
                ->update([
                    'status' => $status,
                ]);

            return [
                'count' => $updatedCount,
                'user_ids' => $changedUserIds,
            ];
        });

        // Send notifications only after the transaction commits
        if (!empty($result['user_ids'])) {

            $notificationData = match ($action) {
                'activate' => [
                    'type'        => 'activated',
                    'subject'     => 'Account Activated',
                    'title'       => 'Account Activated',
                    'message'     => 'Good news! Your account has been activated.',
                    'action_text' => 'Login Now',
                    'url'         => url('/login'),
                ],

                'deactivate' => [
                    'type'        => 'deactivated',
                    'subject'     => 'Account Deactivated',
                    'title'       => 'Account Deactivated',
                    'message'     => 'Your account has been deactivated. Please contact support.',
                    'action_text' => 'Contact Support',
                    'url'         => url('/contact'),
                ],

                'delete' => [
                    'type'        => 'deleted',
                    'subject'     => 'Account deleted',
                    'title'       => 'Account deleted',
                    'message'     => 'Your account has been deleted. Please contact support.',
                    'action_text' => 'Contact Support',
                    'url'         => url('/contact'),
                ],
            };

            User::whereIn('id', $result['user_ids'])
                ->withTrashed($action === 'delete')
                ->chunkById(100, function ($users) use ($notificationData) {

                    Notification::send(
                        $users,
                        new UserStatusNotification($notificationData)
                    );
                });
        }

        return $result['count'];
    }
}
