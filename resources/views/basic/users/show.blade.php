<x-layouts::app :title="__('User Details')">

    <!-- ========================================== -->
    <!-- 4. USERS SHOW DETAILS                       -->
    <!-- ========================================== -->
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Users
                </a>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">User Details</h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-black hover:bg-neutral-800 text-white text-sm font-medium rounded-xl transition">
                    Edit User
                </a>

                <form action="{{ route('users.destroy', $user) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 border border-rose-300 text-rose-600 hover:bg-rose-50 text-sm font-medium rounded-xl transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 flex items-center gap-5 border-b border-gray-100">
                <div class="w-16 h-16 rounded-2xl bg-black text-white flex items-center justify-center font-bold text-xl">
                    
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Jane Doe</h3>
                    <p class="text-sm text-gray-500">jane.doe@example.com</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Admin
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Active
                        </span>
                    </div>
                </div>
            </div>

            <dl class="divide-y divide-gray-100 text-sm">
                <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-gray-500">User ID</dt>
                    <dd class="text-gray-900 sm:col-span-2 font-mono text-xs">USR-948201</dd>
                </div>

                <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-gray-500">Email Verification</dt>
                    <dd class="text-emerald-700 sm:col-span-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Verified on Oct 14, 2024
                    </dd>
                </div>

                <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-gray-500">Account Created</dt>
                    <dd class="text-gray-900 sm:col-span-2">Oct 14, 2024 — 10:30 AM</dd>
                </div>

                <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-gray-500">Last Updated</dt>
                    <dd class="text-gray-900 sm:col-span-2">Oct 28, 2024 — 04:15 PM</dd>
                </div>
            </dl>
        </div>
    </div>

</x-layouts::app>