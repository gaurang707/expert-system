<?php

use App\Models\User;
use App\Notifications\UserStatusNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('bulk deletion notifies only users deleted by that operation', function () {
    Notification::fake();

    $administrator = User::factory()->create();
    $user = User::factory()->create();
    $previouslyDeletedUser = User::factory()->create();
    $previouslyDeletedUser->delete();

    $response = $this->actingAs($administrator)
        ->from(route('users.bulk.action'))
        ->post(route('users.bulk.action.post'), [
            'action' => 'delete',
            'user_ids' => [$user->id, $previouslyDeletedUser->id],
        ]);

    $response->assertRedirect(route('users.bulk.action'))
        ->assertSessionHas('success', '1 users deleted successfully.');

    $this->assertSoftDeleted($user);

    Notification::assertSentTo(
        $user,
        UserStatusNotification::class,
        fn ($notification, $channels) => $notification->data['type'] === 'deleted'
            && $channels === ['mail', 'database'],
    );
    Notification::assertNotSentTo($administrator, UserStatusNotification::class);
    Notification::assertNotSentTo($previouslyDeletedUser, UserStatusNotification::class);
    Notification::assertCount(1);
});
