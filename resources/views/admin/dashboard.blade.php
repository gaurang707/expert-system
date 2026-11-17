<x-inter-layout>

    <!-- Dashboard Content -->
    <div class="space-y-6 m-4">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Dashboard Overview
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Welcome back, Admin! Here's what's happening with your users.
                </p>
            </div>

            <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">
                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                System Active
            </span>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

            <!-- Total Users -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Users</p>
                <h2 class="mt-3 text-3xl font-bold text-gray-900">{{ $states['userTotal'] }}</h2>
                <p class="mt-2 text-xs text-gray-500">All registered accounts</p>
            </div>

            <!-- Active Users -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Active Users</p>
                <h2 class="mt-3 text-3xl font-bold text-green-600">{{ $states['activeUsers'] }}</h2>
                <p class="mt-2 text-xs text-gray-500">{{ $states['activeusersPercentage'] }}% of all users</p>
            </div>

            <!-- Inactive Users -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Inactive Users</p>
                <h2 class="mt-3 text-3xl font-bold text-amber-600">{{ $states['inactiveUsers'] }}</h2>
                <p class="mt-2 text-xs text-gray-500">{{ $states['inactiveusersPercentage'] }}% of all users</p>
            </div>

            <!-- Deleted Users -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Deleted Users</p>
                <h2 class="mt-3 text-3xl font-bold text-red-600">{{ $states['deletedUsers'] }}</h2>
                <p class="mt-2 text-xs text-gray-500">Soft-deleted accounts</p>
            </div>

            <!-- New Users -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">New Users This Month</p>
                <h2 class="mt-3 text-3xl font-bold text-gray-900">{{ $states['registeredThisMonth'] }}</h2>
                <p class="mt-2 text-xs font-medium text-green-600">
                    {{ $states['registeredThisMonthPercentage'] }}% vs. last month
                </p>
            </div>

            <!-- Total Roles -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Roles</p>
                <h2 class="mt-3 text-3xl font-bold text-gray-900">{{ $states['roleTotal'] }}</h2>
                <p class="mt-2 text-xs text-gray-500">Available system roles</p>
            </div>

        </div>

        @php

        $activePerc = $states['activeusersPercentage'];
        $inactivePerc = $states['inactiveusersPercentage'];
        $deletePerc = $states['deletedUsersPercentage'];
        $rolePerceByUser = $states['rolePerceByUser'];
        @endphp

        <!-- Status and Roles -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <!-- Users By Status -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <h3 class="mb-5 text-lg font-semibold text-gray-900">
                    Users by Status
                </h3>


                <!-- Status Progress -->
                <div class="flex h-4 w-full overflow-hidden rounded-full bg-gray-100">

                    <div class="h-full bg-green-500"
                        style="width: {{ $activePerc }}%"></div>
                    <div class="bg-amber-500" style="width:  {{ $inactivePerc }}%"></div>
                    <div class="bg-red-500" style="width:  {{ $deletePerc }}%"></div>
                </div>

                <!-- Legend -->
                <div class="mt-5 flex flex-wrap gap-5 text-sm">

                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full bg-green-500"></span>
                        <span class="text-gray-600">Active</span>
                        <span class="font-semibold">{{ $activePerc }}%</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full bg-amber-500"></span>
                        <span class="text-gray-600">Inactive</span>
                        <span class="font-semibold">{{ $inactivePerc }}%</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full bg-red-500"></span>
                        <span class="text-gray-600">Deleted</span>
                        <span class="font-semibold">{{ $deletePerc }}%</span>
                    </div>

                </div>

            </div>

            <!-- Users By Role -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Users by Role
                    </h3>

                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        {{ $states['roleTotal'] }} Roles
                    </span>
                </div>

                <div class="space-y-4">

                    <!-- Admin -->
                    @forelse ($states['roles'] as $role)

                    <div>
                        <div class="mb-1 flex justify-between text-sm">
                            <span>{{ $role->name }} ({{ $rolePerceByUser[$role->id] }}%)</span>
                            <span class="text-gray-500">{{ $role->users_count }} users</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-100">
                            <div class="h-2 rounded-full bg-blue-500" style="width: {{ $rolePerceByUser[$role->id] }}%"></div>
                        </div>
                    </div>
                    @empty
                    <div>
                        No roles found
                    </div>
                    @endforelse


                </div>

            </div>

        </div>

        <!-- Recent Users -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-gray-200 p-5">
                <h3 class="text-lg font-semibold text-gray-900">
                    Recently Registered Users
                </h3>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                    Last 5 Users
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Id
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Joined
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @foreach ($states['recentlyRegiUsers'] as $recentUser)

                        <tr>
                            <td class="px-6 py-4">
                                {{ $recentUser->id }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-900">{{ $recentUser->name }}</p>
                                <p class="text-xs text-gray-500">{{ $recentUser->email }}</p>
                            </td>
                            <td class="px-6 py-4">

                                @if ($recentUser->trashed())
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">Deleted</span>
                                @else
                                    @if($recentUser->status == 'active')
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Active</span>
                                    @else
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">Inactive</span>
                                    @endif
                                @endif

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">Nov 16, 2026</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</x-inter-layout>