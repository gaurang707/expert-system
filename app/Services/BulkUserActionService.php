<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        return DB::transaction(function () use ($data) {
            $userIds = $data['user_ids'];
            $action = $data['action'];

            if ($action === 'delete') {
                return User::whereIn('id', $userIds)->delete();
            }

            $status = match ($action) {
                'activate' => 'active',
                'deactivate' => 'inactive',
                default => throw new InvalidArgumentException('Invalid bulk action.'),
            };

            return User::whereIn('id', $userIds)
                ->update([
                    'status' => $status,
                ]);
        });
        
    }
}
