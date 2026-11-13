<x-inter-layout>


    <header class="topbar">
        <div class="crumb">Workspace &nbsp;/&nbsp; <strong>Roles &amp; Permissions</strong></div>
        <div class="top-right"><span class="online-label"><span class="online-dot"></span>Role management</span>
            <div class="avatar">AD</div>
        </div>
    </header>
    <div class="content">

    {{-- Success, Error, Warning and Info Messages --}}
@foreach (['success', 'error', 'warning', 'info', 'status'] as $type)

    @if (session()->has($type))

        <div
            class="flash-alert flash-{{ $type === 'status' ? 'success' : $type }}"
            role="{{ in_array($type, ['error', 'warning']) ? 'alert' : 'status' }}"
        >
            {{ session($type) }}
        </div>

    @endif

@endforeach

{{-- Laravel Validation Errors --}}
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

        <div class="eyebrow">✦ ACCESS MANAGEMENT</div>
        <h1>Roles &amp; Permissions</h1>
        <p class="lead">Control who can access what across your application.</p>
        <div class="stats">
            <div class="stat">
                <div>
                    <div class="stat-label">Total Roles</div>
                    <div class="stat-value">{{ $roles->count() }}</div>
                    <div class="stat-note">Across your workspace</div>
                </div>
                <div class="stat-icon">▧</div>
            </div>
            <div class="stat">
                <div>
                    <div class="stat-label">Available Permissions</div>
                    <div class="stat-value">
                        {{ $modules->count() * count($actions) }}
                    </div>
                    <div class="stat-note">Across 4 modules</div>
                </div>
                <div class="stat-icon mint">⌘</div>
            </div>
            <div class="stat">
                <div>
                    <div class="stat-label">Users Assigned</div>
                    <div class="stat-value">28</div>
                    <div class="stat-note">Example assignments</div>
                </div>
                <div class="stat-icon gold">♙</div>
            </div>
        </div>
        <div class="roles-workspace">

            @php
            $role_check = "administrator";
            @endphp

            @foreach ($roles as $role)



            <input
                type="radio"
                class="role-radio"
                id="role-{{ $role->slug }}"
                name="active-role"
                value="{{ $role->id }}"
                aria-label="Show {{ $role->name }} permissions"
                @checked($loop->first)
            />


            @endforeach


            <div class="workspace-grid">
                <section class="panel" aria-labelledby="role-list-heading">
                    <div class="list-head">
                        <div class="list-head-inner">
                            <h2 id="role-list-heading">Roles</h2><span class="count-badge">{{ $roles->count() }} ROLES</span>
                        </div>
                        <p class="list-subtitle">Select a role to see its assigned permissions.</p>
                    </div>
                    <div class="role-items">

                        @php
                        $colorArr = ['purple', 'blue', 'orange', 'green'];

                        @endphp
                        @foreach ($roles as $role)

                        @php
                        $randomColor = $colorArr[array_rand($colorArr)];
                        @endphp

                        <label class="role-choice" for="role-{{ $role->slug }}">
                            <span class="role-letter {{ $randomColor }}">{{ substr($role->name, 0, 1) }}</span>
                            <span class="role-meta">
                                <span class="role-name">{{ $role->name }}</span>
                                <span class="role-users">{{ $role->user_count }} assigned users</span>
                            </span>
                            <span class="role-selected-dot" aria-hidden="true">●</span>
                        </label>

                        @endforeach

                    </div>
                    <div class="list-footer">Four predefined roles</div>
                </section>
                <div class="details">

                    <form id="rolePermissionForm"
                        action="{{ route('roles.permissions.update') }}" method="POST">
                        @csrf



                        @foreach ($roles as $role)

                        <input
                            type="hidden"
                            name="role_ids[]"
                            value="{{ $role->id }}">

                        <article class="panel role-panel role-panel-{{ $role->slug }}" aria-label="{{ $role->name }} permissions">
                            <div class="detail-head">
                                <div class="detail-title-line">
                                    <h3>{{ $role->name }}</h3><span class="type-badge system">SYSTEM ROLE</span>
                                </div>
                                <p class="detail-description">Full access to all workspace features.</p>

                                @php
                                $availablePermissionNames = $modules
                                ->flatMap(
                                fn ($module) => collect(array_keys($actions))
                                ->map(fn ($action) => $module->slug . '.' . $action)
                                )
                                ->all();

                                $enabledCount = $role->permissions
                                ->whereIn('name', $availablePermissionNames)
                                ->count();

                                $totalCount = count($availablePermissionNames);
                                @endphp

                                <div class="enabled-count">
                                    <b>{{ $enabledCount }}</b>
                                    of {{ $totalCount }} permissions enabled
                                </div>


                            </div>
                            <div class="matrix-wrap">

                                <h4 class="matrix-title">Permission matrix</h4>

                                <p class="matrix-note">
                                    Permissions assigned to the {{ $role->name }} role.
                                </p>

                                @foreach ($modules as $module)

                                @php
                                $modulePermissionNames = collect(array_keys($actions))
                                ->map(fn ($action) => $module->slug . '.' . $action)
                                ->all();

                                $assignedCount = $role->permissions
                                ->whereIn('name', $modulePermissionNames)
                                ->count();
                                @endphp

                                <section class="module" aria-label="{{ $module->name }}">

                                    <div class="module-head">

                                        <div class="module-icon users" aria-hidden="true">
                                            ♙
                                        </div>

                                        <div>
                                            <div class="module-name">
                                                {{ $module->name }}
                                            </div>

                                            <div class="module-desc">
                                                Manage {{ $module->name }}
                                            </div>
                                        </div>

                                        <span class="module-count">
                                            {{ $assignedCount }} / {{ count($actions) }}
                                        </span>

                                    </div>

                                    <div class="permissions">

                                        @foreach ($actions as $action => $label)

                                        @php
                                        $permissionName = $module->slug . '.' . $action;

                                        $isChecked = $role->permissions->contains(
                                        'name',
                                        $permissionName
                                        );
                                        @endphp

                                        <div class="permission">

                                            <div class="perm-text">

                                                <div class="perm-label">
                                                    {{ $label }} {{ $module->name }}
                                                </div>

                                                <span class="perm-key">
                                                    {{ $permissionName }}
                                                </span>

                                            </div>

                                            <input
                                                type="checkbox"
                                                name="permissions[{{ $role->id }}][]"
                                                value="{{ $permissionName }}"
                                                @checked($isChecked)
                                                aria-label="{{ $label }} {{ $module->name }} for {{ $role->name }}">

                                        </div>

                                        @endforeach

                                    </div>

                                </section>

                                @endforeach

                            </div>
                            <div class="detail-footer">Permission settings are displayed for review.</div>
                        </article>



                        @endforeach
                        <button type="submit">
                            Update Permissions
                        </button>
                    </form>
                </div>



            </div>
        </div>
    </div>

</x-inter-layout>