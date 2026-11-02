<x-layouts::app :title="__('Users List')">

    <!-- ========================================== -->
    <!-- 1. USERS TABLE LIST (INDEX)                 -->
    <!-- ========================================== -->
    @if (session('success'))
    <div class="flex items-start justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <div>
                <p class="text-sm font-semibold">Success</p>
                <p class="text-sm text-emerald-700">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="flex items-start justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="text-sm font-semibold">Error</p>
                <p class="text-sm text-rose-700">{{ session('error') }}</p>
            </div>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    @endif

    <div>
        <form method="GET" action="{{ route('users.index') }}"
            class="flex flex-wrap items-center gap-3 mb-6">
            <div>
                <!-- Search -->
                <input
                    type="search"
                    name="search"
                    value="{{ old('search', $search) }}"
                    placeholder="Search name or email..."
                    class="border rounded-lg px-4 py-2
               @error('search') border-red-500 @enderror">


                @error('search')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div>
                <!-- Role -->
                <select name="role_id"
                    class="border border-gray-300 rounded-lg px-4 py-2 @error('role_id') border-red-500 @enderror">

                    <option value="{{ old('role_id', $roleId) }}">All Roles</option>

                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}"
                        @selected((string) $roleId===(string) $role->id)>
                        {{ $role->display_name }}
                    </option>
                    @endforeach
                </select>

                @error('role_id')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div>
                <!-- Per Page -->
                <select name="per_page"
                    class="border border-gray-300 rounded-lg px-4 py-2 @error('role_id') border-red-500 @enderror">

                    @foreach ([10, 25, 50, 100] as $limit)
                    <option value="{{ $limit }}"
                        @selected($perPage===$limit)>
                        {{ $limit }} per page
                    </option>
                    @endforeach
                </select>
                @error('per_page')

                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror

            </div>


            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg">
                Search
            </button>

            <a href="{{ route('users.index') }}"
                class="border border-gray-300 px-5 py-2 rounded-lg">
                Reset
            </a>
        </form>
    </div>

    <div class="max-w-6xl mx-auto mb-16">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Users</h2>
                <p class="text-sm text-gray-500 mt-1">Manage all registered user accounts and their roles.</p>
            </div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-black hover:bg-neutral-800 text-white text-sm font-medium rounded-xl transition">
                Add User
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-3.5">User</th>
                            <th class="px-6 py-3.5">Role</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5">Joined</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">

                        @forelse ($users as $user)

                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-black text-white flex items-center justify-center font-semibold text-xs">
                                        {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900 block">{{ $user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $user->role->display_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('users.show', $user) }}" class="p-1.5 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="p-1.5 text-gray-500 hover:text-indigo-600 rounded-lg hover:bg-gray-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form method="post" action="{{ route('users.destroy', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-500 hover:text-rose-600 rounded-lg hover:bg-gray-100 transition" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                    <!-- Trigger Button -->
                                    <button
                                        type="button"
                                        class="openEditModal bg-blue-600 text-white px-4 py-2 rounded-lg"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role_id }}"
                                        data-update-url="{{ route('users.updatemodal', $user) }}">
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td>No users found</td>
                        </tr>
                        @endforelse
                        <!-- <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-neutral-700 text-white flex items-center justify-center font-semibold text-xs">
                                        AS
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900 block">Alex Smith</span>
                                        <span class="text-xs text-gray-500">alex.smith@example.com</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Member
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Inactive
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Nov 03, 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="inline-flex items-center gap-2">
                                    <button type="button" class="p-1.5 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button type="button" class="p-1.5 text-gray-500 hover:text-indigo-600 rounded-lg hover:bg-gray-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button type="button" class="p-1.5 text-gray-500 hover:text-rose-600 rounded-lg hover:bg-gray-100 transition" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
                <!-- <span>Showing 1 to 2 of 2 results</span> -->
                <div>
                    Showing {{ $users->firstItem() ?? 0 }}
                    to {{ $users->lastItem() ?? 0 }}
                    of {{ $users->total() }} results
                </div>

                {{ $users->links() }}
                <div class="inline-flex gap-2">
                    <button type="button" class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50" disabled>Previous</button>
                    <button type="button" class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <!-- Modal Wrapper -->
    <div id="modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">

        <!-- Backdrop -->
        <div id="modalOverlay"
            class="absolute inset-0 bg-gray-900/60 backdrop-blur-xs">
        </div>

        <!-- Modal Content -->
        <div class="relative z-10 bg-white rounded-xl shadow-xl
                w-full max-w-6xl max-h-[90vh]
                flex flex-col overflow-hidden">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 shrink-0">
                <h3 class="text-xl font-semibold text-gray-900">
                    Edit User
                </h3>
            </div>

            <form id="editUserForm" class="flex flex-col min-h-0">
                @csrf
                @method('PUT')

                <!-- Scrollable Content -->
                <div class="p-6 overflow-y-auto grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Name -->
                    <div>
                        <label class="block mb-2 text-sm font-medium">Name</label>
                        <input type="text" name="name" id="edit_name"
                            class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block mb-2 text-sm font-medium">Email</label>
                        <input type="email" name="email" id="edit_email"
                            class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block mb-2 text-sm font-medium">Role</label>
                        <select name="role_id" id="edit_role_id"
                            class="w-full border border-gray-300 rounded-lg p-3">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->display_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block mb-2 text-sm font-medium">
                            New Password (Optional)
                        </label>
                        <input type="password" name="password" id="edit_password"
                            class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block mb-2 text-sm font-medium">
                            Confirm Password
                        </label>
                        <input type="password" name="password_confirmation"
                            id="edit_password_confirmation"
                            class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-200
                        flex justify-end gap-3 bg-gray-50 shrink-0">
                    <button type="button" id="closeModalBtn"
                        class="px-5 py-2 border rounded-lg">
                        Cancel
                    </button>

                    <button type="submit" id="updateUserBtn"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            const $modal = $('#modal');
            const $form = $('#editUserForm');
            const $updateBtn = $('#updateUserBtn');

            let isSubmitting = false;

            // Open modal
            $(document).on('click', '.openEditModal', function() {

                const $button = $(this);

                $form[0].reset();
                clearErrors();

                $('#edit_user_id').val($button.attr('data-id'));
                $('#edit_name').val($button.attr('data-name'));
                $('#edit_email').val($button.attr('data-email'));
                $('#edit_role_id').val($button.attr('data-role'));

                $form.attr('action', $button.attr('data-update-url'));

                $modal.removeClass('hidden');

                $('body').addClass('overflow-hidden');

                $('#edit_name').trigger('focus');
            });

            // Close modal
            $('#closeModalBtn, #closeModalCross, #modalOverlay')
                .on('click', function() {
                    closeModal();
                });

            // Escape key
            $(document).on('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });

            function closeModal() {
                if (isSubmitting) return;

                $modal.addClass('hidden');
                $('body').removeClass('overflow-hidden');
            }

            // Clear validation errors
            function clearErrors() {

                $form.find('[class*="error-"]').text('');

                $form.find('input, select')
                    .removeClass('border-red-500');

                $('#generalError')
                    .addClass('hidden')
                    .text('');
            }

            // Submit form using AJAX
            $form.on('submit', function(event) {

                event.preventDefault();

                if (isSubmitting) return;

                clearErrors();

                const userId = $('#edit_user_id').val();

                jQuery.ajax({
                    url: $form.attr('action'),
                    type: 'POST',

                    data: $form.serialize(),

                    headers: {
                        'Accept': 'application/json'
                    },

                    beforeSend: function() {
                        isSubmitting = true;

                        $updateBtn
                            .prop('disabled', true)
                            .text('Updating...');
                    },

                    success: function(response) {

                        if (!response.success) {
                            showGeneralError(
                                response.message || 'Update failed.'
                            );
                            return;
                        }

                        const user = response.user;

                        // Update table row
                        const $row = $('#user-row-' + user.id);

                        $row.find('[data-field="name"]')
                            .text(user.name);

                        $row.find('[data-field="email"]')
                            .text(user.email);

                        $row.find('[data-field="role"]')
                            .text(user.role_name);

                        // Update button attributes
                        const $editButton = $row.find('.openEditModal');

                        $editButton.attr('data-name', user.name);
                        $editButton.attr('data-email', user.email);
                        $editButton.attr('data-role', user.role_id ?? '');

                        $modal.addClass('hidden');
                        $('body').removeClass('overflow-hidden');

                        // Show success message
                        alert(response.message || 'User updated successfully.');
                    },

                    error: function(xhr) {

                        if (xhr.status === 422) {

                            const errors = xhr.responseJSON?.errors || {};

                            $.each(errors, function(field, messages) {

                                const $input = $form.find(
                                    '[name="' + field + '"]'
                                );

                                $input.addClass('border-red-500');

                                $form.find('.error-' + field)
                                    .text(messages[0]);
                            });

                        } else if (xhr.status === 403) {
                            showGeneralError(
                                'You do not have permission to update this user.'
                            );

                        } else if (xhr.status === 419) {
                            showGeneralError(
                                'Your session has expired. Refresh and try again.'
                            );

                        } else {
                            showGeneralError(
                                xhr.responseJSON?.message ||
                                'Something went wrong. Please try again.'
                            );
                        }
                    },

                    complete: function() {
                        isSubmitting = false;

                        $updateBtn
                            .prop('disabled', false)
                            .text('Update User');
                    }
                });
            });

            function showGeneralError(message) {
                $('#generalError')
                    .removeClass('hidden')
                    .text(message);
            }

        });
    </script>

</x-layouts::app>