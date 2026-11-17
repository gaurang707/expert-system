<x-inter-layout>


    <section class="bulk-users">
        @foreach (['success', 'error', 'warning', 'info', 'status'] as $type)

        @if (session()->has($type))

        <div
            class="flash-alert flash-{{ $type === 'status' ? 'success' : $type }}"
            role="{{ in_array($type, ['error', 'warning']) ? 'alert' : 'status' }}">
            {{ session($type) }}
        </div>

        @endif
        @endforeach

        @if (session('bulk_results'))
        <ul class="space-y-2">
            @foreach (session('bulk_results') as $result)
            <li>
                User {{ $result['id'] }} —
                <span @class([ 'text-red-600 font-semibold'=>
                    $result['status'] !== 'Valid',
                    'text-green-600' =>
                    $result['status'] === 'Valid',
                    ])>
                    {{ $result['status'] }}
                </span>
            </li>
            @endforeach
        </ul>
        @endif

        @if ($errors->any())

        <div class="flash-alert flash-error" role="alert">

            <strong>Please correct the following errors:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

        @endif
        <div class="bulk-users__header">

            <div>
                <h2>User Management</h2>
                <p>Select users to activate, deactivate, or delete.</p>
            </div>
            <span class="users-count">4 Users</span>
        </div>

        <form action="{{ route('users.bulk.action.post') }}" method="POST">
            @csrf

            <div class="bulk-users__toolbar">
                <div class="bulk-users__actions">
                    <select name="action" required>
                        <option value="">Select Bulk Action</option>
                        <option value="activate" @if(old('action')=='activate' ) selected @endif>Activate Users</option>
                        <option value="deactivate" @if(old('action')=='deactivate' ) selected @endif>Deactivate Users</option>
                        <option value="delete" @if(old('action')=='delete' ) selected @endif>Delete Users</option>
                    </select>

                    <button type="submit" class="btn-primary">
                        Apply Action
                    </button>
                </div>

                <span class="toolbar-note">
                    Maximum 50 users per action
                </span>
            </div>

            <div class="bulk-users__table-wrapper">
                <table id="userTable" class="bulk-users__table">
                    <thead>
                        <tr>
                            <th class="checkbox-column">
                                Select
                                <!-- <input type="checkbox" id="checkall" /> -->
                            </th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined Date</th>

                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($users as $user)
                        <tr>

                            <td>
                                 @if (!$user->trashed())
                                <input type="checkbox"
                                    name="user_ids[]"
                                    value="{{ $user->id }}">
                                    @endif
                            </td>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="user-info">
                                    <span class="avatar">{{ substr($user->name, 0, 2) }}</span>
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <small>{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                            <td>
                                @if ($user->trashed())
                                <span class="status text-red-600">Deleted</span>
                                @else
                                <span class="status @if($user->status=='active')  active @else inactive @endif">{{ $user->status }}</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <h2>No users found</h2>
                            </td>
                        </tr>
                        @endforelse



                        <!-- <tr>
                            <td>
                                <input type="checkbox"
                                    name="user_ids[]"
                                    value="2">
                            </td>
                            <td>
                                <div class="user-info">
                                    <span class="avatar">RS</span>
                                    <div>
                                        <strong>Rahul Shah</strong>
                                        <small>rahul@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>User</td>
                            <td>
                                <span class="status inactive">Inactive</span>
                            </td>
                            <td>09 Nov 2026</td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox"
                                    name="user_ids[]"
                                    value="3">
                            </td>
                            <td>
                                <div class="user-info">
                                    <span class="avatar">PP</span>
                                    <div>
                                        <strong>Priya Patel</strong>
                                        <small>priya@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>Manager</td>
                            <td>
                                <span class="status active">Active</span>
                            </td>
                            <td>08 Nov 2026</td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox"
                                    name="user_ids[]"
                                    value="4">
                            </td>
                            <td>
                                <div class="user-info">
                                    <span class="avatar">AK</span>
                                    <div>
                                        <strong>Amit Kumar</strong>
                                        <small>amit@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>User</td>
                            <td>
                                <span class="status inactive">Inactive</span>
                            </td>
                            <td>07 Nov 2026</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>

            <div class="bulk-users__footer">
                <span>
                    {{
                        $users->links()
                    }}
                </span>
                <span>Showing 4 users</span>
            </div>
        </form>
    </section>

</x-inter-layout>