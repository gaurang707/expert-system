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
            3 Unread
        </span>
    </div>

    <!-- Notification Card -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <!-- Filters -->
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 p-4">

            <div class="inline-flex rounded-lg bg-gray-100 p-1">
                <button type="button"
                    class="rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-900 shadow-sm">
                    All
                </button>

                <button type="button"
                    class="rounded-md px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-900">
                    Unread
                </button>

                <button type="button"
                    class="rounded-md px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-900">
                    Read
                </button>
            </div>

            <button type="button"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Mark All as Read
            </button>
        </div>

        <!-- Notification List -->
        <div class="divide-y divide-gray-100">

            <!-- Notification 1: Unread -->
            <div class="bg-blue-50/60 p-4 sm:p-5">
                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                        <span class="text-lg">👤</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-gray-900">
                                New User Registered
                            </h3>
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        </div>

                        <p class="mt-1 text-sm text-gray-600">
                            Rahul Shah has created a new account.
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            2 minutes ago
                        </p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button"
                                class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                Mark as Read
                            </button>

                            <button type="button"
                                class="rounded-md px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification 2: Unread -->
            <div class="bg-blue-50/60 p-4 sm:p-5">
                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                        <span class="text-lg">⚠️</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-gray-900">
                                User Account Deactivated
                            </h3>
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        </div>

                        <p class="mt-1 text-sm text-gray-600">
                            The account for Amit Mehta was deactivated.
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            15 minutes ago
                        </p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button"
                                class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                Mark as Read
                            </button>

                            <button type="button"
                                class="rounded-md px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification 3: Unread -->
            <div class="bg-blue-50/60 p-4 sm:p-5">
                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-600">
                        <span class="text-lg">✅</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-gray-900">
                                Bulk Action Completed
                            </h3>
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        </div>

                        <p class="mt-1 text-sm text-gray-600">
                            5 user accounts were activated successfully.
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            1 hour ago
                        </p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button"
                                class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                Mark as Read
                            </button>

                            <button type="button"
                                class="rounded-md px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification 4: Read -->
            <div class="bg-white p-4 sm:p-5">
                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                        <span class="text-lg">👤</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h3 class="font-medium text-gray-700">
                            New User Registered
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Priya Patel has joined your platform.
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            Yesterday
                        </p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button"
                                class="rounded-md border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50">
                                Mark as Unread
                            </button>

                            <button type="button"
                                class="rounded-md px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification 5: Read -->
            <div class="bg-white p-4 sm:p-5">
                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                        <span class="text-lg">✅</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h3 class="font-medium text-gray-700">
                            Profile Updated
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Your account profile was updated successfully.
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            2 days ago
                        </p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button"
                                class="rounded-md border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50">
                                Mark as Unread
                            </button>

                            <button type="button"
                                class="rounded-md px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="flex items-center justify-between border-t border-gray-200 px-5 py-4">
            <p class="text-sm text-gray-500">
                Showing 5 notifications
            </p>

            <div class="flex gap-2">
                <button type="button"
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    Previous
                </button>

                <button type="button"
                    class="rounded-lg bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700">
                    Next
                </button>
            </div>
        </div>

    </div>

</div>

</x-layouts::app>
