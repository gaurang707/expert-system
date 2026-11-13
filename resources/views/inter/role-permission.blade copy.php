<x-inter-layout>

    <header class="topbar">
        <div class="crumb">Workspace &nbsp;/&nbsp; <strong>Roles &amp; Permissions</strong></div>
        <div class="top-right"><span class="online-label"><span class="online-dot"></span>Role management</span>
            <div class="avatar">AD</div>
        </div>
    </header>
    <div class="content">
        <div class="eyebrow">✦ ACCESS MANAGEMENT</div>
        <h1>Roles &amp; Permissions</h1>
        <p class="lead">Control who can access what across your application.</p>
        <div class="stats">
            <div class="stat">
                <div>
                    <div class="stat-label">Total Roles</div>
                    <div class="stat-value">{{ $totalRole ?? 0 }}</div>
                    <div class="stat-note">Across your workspace</div>
                </div>
                <div class="stat-icon">▧</div>
            </div>
            <div class="stat">
                <div>
                    <div class="stat-label">Available Permissions</div>
                    <div class="stat-value">{{ $actionTotal ?? 0 }}</div>
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
            <input type="radio" class="role-radio" id="role-admin" name="active-role" aria-label="Show Administrator permissions">
            <input type="radio" class="role-radio" id="role-manager" name="active-role" aria-label="Show Manager permissions" checked>
            <input type="radio" class="role-radio" id="role-editor" name="active-role" aria-label="Show Editor permissions">
            <input type="radio" class="role-radio" id="role-viewer" name="active-role" aria-label="Show Viewer permissions">
            <div class="workspace-grid">
                <section class="panel" aria-labelledby="role-list-heading">
                    <div class="list-head">
                        <div class="list-head-inner">
                            <h2 id="role-list-heading">Roles</h2><span class="count-badge">{{ $totalRole ?? 0 }} ROLES</span>
                        </div>
                        <p class="list-subtitle">Select a role to see its assigned permissions.</p>
                    </div>
                    @php
                    $colorArr = ['purple', 'blue', 'orange', 'green'];

                    @endphp
                    <div class="role-items">

                        @foreach ($roles as $role)
                        @php
                        $randomKey = array_rand($colorArr);
                        $randomValue = $colorArr[$randomKey];
                        @endphp
                        <label class="role-choice" for="role-{{ $role->slug }}">
                            <span class="role-letter {{ $randomValue }}">{{ substr($role->name, 0, 1) }}</span>
                            <span class="role-meta"><span class="role-name">{{ ucfirst(strtolower($role->name)) }}</span>
                                <span class="role-users">{{ $role->users_count }} assigned users</span></span>
                            <span class="role-selected-dot" aria-hidden="true">●</span>
                        </label>
                        @endforeach

                        <!-- <label class="role-choice" for="role-manager"><span class="role-letter blue">M</span><span class="role-meta"><span class="role-name">Manager</span><span class="role-users">8 assigned users</span></span><span class="role-selected-dot" aria-hidden="true">●</span></label>
                        <label class="role-choice" for="role-editor"><span class="role-letter orange">E</span><span class="role-meta"><span class="role-name">Editor</span><span class="role-users">12 assigned users</span></span><span class="role-selected-dot" aria-hidden="true">●</span></label>
                        <label class="role-choice" for="role-viewer"><span class="role-letter green">V</span><span class="role-meta"><span class="role-name">Viewer</span><span class="role-users">5 assigned users</span></span><span class="role-selected-dot" aria-hidden="true">●</span></label> -->
                    </div>
                    <div class="list-footer">Four predefined roles</div>
                </section>
                <div class="details">
                    

                    @foreach ($roles as $role)

                    @foreach ($modules as $module)
                                @php 
                                    $permission_name = "permission_".$module->id;
                                    
                                @endphp 

                    <article class="panel role-panel role-panel-{{ $role->slug }}" aria-label="{{ $role->name}} permissions">
                        <div class="detail-head">
                            <div class="detail-title-line">
                                <h3>{{ $role->name }}</h3><span class="type-badge">CUSTOM ROLE</span>
                            </div>
                            <p class="detail-description">Can manage {{ $role->slug }} and daily business operations.</p>
                            <div class="enabled-count"><b>10</b> of 16 permissions enabled</div>
                        </div>
                        <div class="matrix-wrap">
                            <h4 class="matrix-title">Permission matrix</h4>
                            <p class="matrix-note">Permissions assigned to the Manager role.</p>


                            
                            <section class="module" aria-label="{{ $module->slug }}">
                                <div class="module-head">
                                    <div class="module-icon {{ $module->slug }}" aria-hidden="true">♙</div>
                                    <div>
                                        <div class="module-name">{{ $module->name }}</div>
                                        <div class="module-desc">Manage team members and user accounts</div>
                                    </div><span class="module-count">0 / 4</span>
                                </div>
                                <div class="permissions">
                                    <div class="permission">
                                        <div class="perm-text">
                                            <div class="perm-label">View {{ $module->slug }}</div><span class="perm-key">{{ strtolower($module->slug) }}.view</span>
                                        </div><input name="{{ $permission_name }}[]" type="checkbox" aria-label="View {{ strtolower($module->slug) }}: enabled for Manager">
                                    </div>
                                    <div class="permission">
                                        <div class="perm-text">
                                            <div class="perm-label">Create {{ strtolower($module->slug) }}</div><span class="perm-key">{{ strtolower($module->slug) }}.create</span>
                                        </div><input name="{{ $permission_name }}[]" type="checkbox" aria-label="Create {{ strtolower($module->slug) }}: enabled for Manager">
                                    </div>
                                    <div class="permission">
                                        <div class="perm-text">
                                            <div class="perm-label">Edit {{ strtolower($module->slug) }}</div><span class="perm-key">{{ strtolower($module->slug) }}.edit</span>
                                        </div><input name="{{ $permission_name }}[]" type="checkbox" aria-label="Edit {{ strtolower($module->slug) }}: enabled for Manager">
                                    </div>
                                    <div class="permission">
                                        <div class="perm-text">
                                            <div class="perm-label">Delete {{ strtolower($module->slug) }}</div><span class="perm-key">{{ strtolower($module->slug) }}.delete</span>
                                        </div><input name="{{ $permission_name }}[]"  type="checkbox" aria-label="Delete {{ strtolower($module->slug) }}: disabled for Manager">
                                    </div>
                                </div>
                            </section>
                            @endforeach
                        </div>
                        <div class="detail-footer">Permission settings are displayed for review.</div>
                    </article>
                    @endforeach


                  
                </div>
            </div>
        </div>
    </div>

</x-inter-layout>