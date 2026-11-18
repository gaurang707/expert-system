<x-layouts::app :title="__('Notification')">

    <div class="mx-auto max-w-5xl space-y-6 p-4 sm:p-6">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Notifications
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Stay updated with account activity
                </p>
            </div>

            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700">
                {{ $unreadCount }} Unread
            </span>
        </div>

        @if (session('success'))
        <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
        @endif

        <!-- Notification Card -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <!-- Filters -->
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 p-4">

                <div class="inline-flex rounded-lg bg-gray-100 p-1">
                    @foreach (['all' => 'All', 'unread' => 'Unread', 'read' => 'Read'] as $value => $label)
                    <a
                        href="{{ route('admin.notifications.index', ['filter' => $value]) }}"
                        @class([ 'rounded-md px-4 py-2 text-sm font-medium transition' , 'bg-white text-gray-900 shadow-sm'=> $filter === $value,
                        'text-gray-500 hover:text-gray-900' => $filter !== $value,
                        ])
                        >
                        {{ $label }}
                    </a>
                    @endforeach
                </div>

                <!-- Mark All as Read -->
                <form
                    method="POST"
                    action="{{ route('admin.notifications.mark-all-read') }}">
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        @disabled($unreadCount===0)
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50">
                        Mark All as Read
                    </button>
                </form>
            </div>

            <!-- Notification List -->
            <div class="divide-y divide-gray-100">

                @forelse ($notifications as $notification)

                @php
                $isUnread = is_null($notification->read_at);

                $type = $notification->data['type'] ?? 'general';

                $title = $notification->data['title']
                ?? $notification->data['subject']
                ?? 'New Notification';

                $message = $notification->data['message']
                ?? 'You have a new notification.';

                $icon = match ($type) {
                'activated' => '✅',
                'deactivated' => '⚠️',
                'registered' => '👤',
                default => '🔔',
                };

                $iconClasses = match ($type) {
                'activated' => 'bg-green-100 text-green-600',
                'deactivated' => 'bg-amber-100 text-amber-600',
                'registered' => 'bg-blue-100 text-blue-600',
                default => 'bg-gray-100 text-gray-600',
                };
                @endphp

                <div @class([ 'p-4 sm:p-5' , 'bg-blue-50/60'=> $isUnread,
                    'bg-white' => !$isUnread,
                    ])>

                    <div class="flex items-start gap-3">

                        <!-- Icon -->
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $iconClasses }}">
                            <span class="text-lg">
                                {{ $icon }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="min-w-0 flex-1">

                            <div class="flex items-center gap-2">

                                <h3 @class([ 'text-gray-900'=> $isUnread,
                                    'text-gray-700' => !$isUnread,
                                    'font-semibold' => $isUnread,
                                    'font-medium' => !$isUnread,
                                    ])>
                                    {{ $title }}
                                </h3>

                                @if ($isUnread)
                                <span class="h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                                @endif

                            </div>

                            <!-- Message -->
                            <p class="mt-1 text-sm text-gray-600">
                                {{ $message }}
                            </p>

                            <!-- Created Date -->
                            <p class="mt-2 text-xs text-gray-400">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>

                            <!-- Actions -->
                            <div class="mt-3 flex flex-wrap gap-2">

                                <!-- Mark Read / Unread -->
                                <form
                                    method="POST"
                                    action="{{ route('admin.notifications.toggle-read', $notification->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                        {{ $isUnread ? 'Mark as Read' : 'Mark as Unread' }}
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form
                                    method="POST"
                                    action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                    onsubmit="return confirm('Delete this notification?');">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-md px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

                @empty

                <!-- Empty State -->
                <div class="px-6 py-14 text-center">

                    <div class="mb-3 text-4xl">
                        🔔
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900">
                        No notifications found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        @if ($filter === 'unread')
                        You're all caught up! No unread notifications.
                        @elseif ($filter === 'read')
                        You haven't read any notifications yet.
                        @else
                        You don't have any notifications yet.
                        @endif
                    </p>

                </div>

                @endforelse

            </div>

            <!-- Dynamic Pagination -->
            @if ($notifications->hasPages())

            <div class="border-t border-gray-200 px-5 py-4">

                <p class="mb-3 text-sm text-gray-500">
                    Showing {{ $notifications->firstItem() }}
                    to {{ $notifications->lastItem() }}
                    of {{ $notifications->total() }} notifications
                </p>

                {{ $notifications->links() }}

            </div>

            @endif

        </div>

    </div>

</x-layouts::app>