<x-inter-layout>
    <header class="h-[76px] bg-white border-b border-slate-200 flex justify-between items-center px-5 md:px-9">
        <div class="flex items-center gap-3"><button id="mobileMenu" class="lg:hidden p-2 rounded-lg border border-slate-200" aria-label="Open menu">☰</button>
            <div class="text-xs md:text-sm text-slate-400">Workspace <span class="mx-2">/</span> <span class="text-ink font-semibold">Roles & Permissions</span></div>
        </div>
        <div class="flex items-center gap-4"><span class="hidden sm:flex text-xs text-slate-400 items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> All systems operational</span><button class="relative w-9 h-9 rounded-full border border-slate-200 bg-slate-50" title="Notifications">♧<span class="absolute w-2 h-2 bg-red-400 rounded-full top-1 right-1"></span></button>
            <div class="w-9 h-9 bg-[#e8ecff] text-[#5062c8] rounded-full flex justify-center items-center text-xs font-extrabold">AD</div>
        </div>
    </header>
    <div class="px-5 md:px-9 py-9 max-w-[1530px] mx-auto">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-8">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs text-brand-600 font-bold bg-brand-50 px-3 py-1 rounded-full mb-3">✦ ACCESS MANAGEMENT</div>
                <h1 class="font-display text-[28px] md:text-[32px] tracking-[-.055em] font-extrabold">Roles & Permissions</h1>
                <p class="text-sm text-slate-500 mt-2">Control who can access what across your application.</p>
            </div>
            <button id="newRoleBtn" class="rounded-xl bg-brand-600 hover:bg-brand-700 transition text-white px-5 py-3 text-sm font-bold shadow-md shadow-indigo-100 flex gap-2 items-center justify-center"><span class="text-lg leading-none">+</span> Create New Role</button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="rounded-2xl bg-white border border-slate-200 p-5 glass-shadow flex justify-between items-start">
                <div>
                    <p class="text-xs text-slate-500 font-semibold">Total Roles</p>
                    <div id="statRoles" class="font-display text-[29px] font-extrabold mt-1">4</div>
                    <p class="text-[11px] text-slate-400 mt-1">Across your workspace</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#eef1ff] text-[#5d76e9] flex items-center justify-center text-xl">▧</div>
            </div>
            <div class="rounded-2xl bg-white border border-slate-200 p-5 glass-shadow flex justify-between items-start">
                <div>
                    <p class="text-xs text-slate-500 font-semibold">Available Permissions</p>
                    <div class="font-display text-[29px] font-extrabold mt-1">16</div>
                    <p class="text-[11px] text-slate-400 mt-1">Across 4 modules</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#e8faf4] text-[#18a67f] flex items-center justify-center text-xl">⌘</div>
            </div>
            <div class="rounded-2xl bg-white border border-slate-200 p-5 glass-shadow flex justify-between items-start">
                <div>
                    <p class="text-xs text-slate-500 font-semibold">Users Assigned</p>
                    <div class="font-display text-[29px] font-extrabold mt-1">28</div>
                    <p class="text-[11px] text-slate-400 mt-1">Sample workspace data</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#fff3e7] text-[#d9973c] flex items-center justify-center text-xl">♙</div>
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-[315px_minmax(0,1fr)] gap-6 items-start">
            <section class="rounded-2xl bg-white border border-slate-200 glass-shadow overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-display font-extrabold text-base">Roles</h2><span id="roleCountBadge" class="pill bg-slate-100 text-slate-600">4 ROLES</span>
                    </div>
                    <div class="relative"><span class="absolute left-3 top-[10px] text-slate-400">⌕</span><input id="roleSearch" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-9 pr-3 text-sm placeholder:text-slate-400" placeholder="Search roles..." aria-label="Search roles" /></div>
                </div>
                <div id="roleList" class="p-3 space-y-1"></div>
                <div class="p-4 border-t border-slate-100 bg-slate-50/60 text-center">
                    <p class="text-xs text-slate-400">Select a role to manage its permissions</p>
                </div>
            </section>
            <section class="rounded-2xl bg-white border border-slate-200 glass-shadow overflow-hidden">
                <div class="p-5 md:p-7 border-b border-slate-100">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 id="editingTitle" class="font-display font-extrabold text-xl">Manager</h2><span id="editingBadge" class="pill bg-blue-50 text-blue-700">CUSTOM ROLE</span>
                            </div>
                            <p id="editingDescription" class="text-sm text-slate-500 mt-1.5">Can manage users and daily business operations.</p>
                        </div><button id="deleteRole" class="text-sm font-semibold text-slate-400 hover:text-red-600 border border-slate-200 rounded-lg px-3 py-2">Delete role</button>
                    </div>
                    <div class="flex gap-2 mt-5">
                        <div class="rounded-lg bg-slate-50 text-xs py-2 px-3"><span class="font-extrabold" id="selectedCount">0</span> of 16 permissions enabled</div>
                        <div id="unsavedIndicator" class="hidden rounded-lg bg-amber-50 text-amber-700 text-xs py-2 px-3 font-semibold">Unsaved changes</div>
                    </div>
                </div>
                <div class="p-5 md:p-7">
                    <div class="flex justify-between gap-3 items-center mb-5">
                        <div>
                            <h3 class="font-display font-bold">Permission matrix</h3>
                            <p class="text-xs text-slate-400 mt-1">Enable the actions this role can perform.</p>
                        </div><button id="allToggle" class="text-xs text-brand-600 font-bold hover:underline whitespace-nowrap">Select all</button>
                    </div>
                    <div id="permissionGroups" class="space-y-5"></div>
                </div>
                <div class="p-5 md:px-7 border-t border-slate-100 bg-slate-50/60 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                    <p class="text-xs text-slate-400">Changes affect users assigned to this role.</p>
                    <div class="flex gap-2 w-full sm:w-auto"><button id="discardBtn" class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-50">Discard</button><button id="saveBtn" class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700">Save Permissions</button></div>
                </div>
            </section>
        </div>
        <div class="mt-6 rounded-2xl border border-[#d8e3fc] bg-[#f0f5ff] p-5 flex gap-3 items-start">
            <div class="w-8 h-8 rounded-lg bg-white text-brand-600 flex items-center justify-center shrink-0">ⓘ</div>
            <div>
                <h3 class="font-bold text-sm">Laravel integration note</h3>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed">This is a standalone frontend demo. When connected to Laravel, send selected permission IDs to your controller, use <code class="font-mono text-xs bg-white px-1.5 py-1 rounded">$role->permissions()->sync($ids)</code>, and enforce permissions on the server using policies or gates.</p>
            </div>
        </div>
    </div>
</x-inter-layout>