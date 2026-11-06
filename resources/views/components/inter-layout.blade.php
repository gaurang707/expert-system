<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Laravel Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f5f7fb] text-ink min-h-screen">
    <div class="min-h-screen lg:flex">
        <aside id="sidebar" class="hidden lg:flex w-[250px] bg-[#1b2940] text-white flex-col shrink-0 min-h-screen">
            <div class="px-7 pt-8 pb-9 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8498ff] to-[#4967e5] flex items-center justify-center shadow-lg"><svg width="23" height="23" fill="none" stroke="white" stroke-width="2.3" viewBox="0 0 24 24">
                        <path d="M12 3 3 7v5c0 5.2 3.6 8.2 9 9 5.4-.8 9-3.8 9-9V7l-9-4Z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg></div>
                <div>
                    <div class="font-display font-extrabold tracking-tight text-lg">Gatekeeper</div>
                    <div class="text-[10px] text-slate-400 tracking-[.19em] font-bold uppercase">Admin workspace</div>
                </div>
            </div>
            <div class="px-5 text-[10px] tracking-[.17em] uppercase text-slate-500 font-bold mb-3">Workspace</div>
            <nav class="px-3 space-y-1">
                <a class="side-item" href="#overview"><span>▦</span> Overview</a>
                <a class="side-item" href="#users"><span>♙</span> Users</a>
                <a class="side-item active" href="#roles"><span>▧</span> Roles & Permissions</a>
                <a class="side-item" href="#activity"><span>◷</span> Activity Logs</a>
            </nav>
            <div class="px-5 text-[10px] tracking-[.17em] uppercase text-slate-500 font-bold mt-9 mb-3">Management</div>
            <nav class="px-3 space-y-1"><a class="side-item" href="#settings"><span>⚙</span> Settings</a><a class="side-item" href="#help"><span>ⓘ</span> Help & Support</a></nav>
            <div class="mt-auto p-5">
                <div class="rounded-2xl bg-[#293b55] p-4">
                    <div class="flex items-center gap-2 mb-2"><span class="text-green-300">●</span><span class="text-xs font-bold">System healthy</span></div>
                    <p class="text-xs text-slate-400 leading-relaxed">All permission rules are ready for review.</p>
                </div>
                <div class="flex gap-3 items-center pt-6">
                    <div class="w-9 h-9 rounded-full bg-[#5777c3] flex items-center justify-center font-bold text-xs">AD</div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold">Admin User</p>
                        <p class="text-[11px] text-slate-400">Super Administrator</p>
                    </div><span class="ml-auto text-slate-400">⋯</span>
                </div>
            </div>
        </aside>
        <main class="flex-1 min-w-0">
            {{ $slot }}
        </main>
    </div>

    <!-- <div id="toast" class="toast fixed z-50 bottom-6 right-6 bg-[#22334b] text-white rounded-xl px-5 py-3 shadow-xl text-sm font-semibold" role="status" aria-live="polite"></div> -->

    <!-- <div id="modal" class="hidden fixed inset-0 bg-slate-950/50 z-40 items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center">
                <h2 id="modalTitle" class="text-lg font-extrabold font-display">Create New Role</h2><button id="closeModal" class="text-slate-400 text-2xl" aria-label="Close">×</button>
            </div>
            <p class="text-xs text-slate-500 mt-1 mb-5">Create a role, then choose its permissions.</p>
            <form id="newRoleForm"><label for="newRoleName" class="text-xs font-bold text-slate-700">Role name</label><input id="newRoleName" required maxlength="40" class="w-full mt-1 mb-4 border border-slate-200 rounded-lg p-3 text-sm" placeholder="e.g. Content Reviewer" /><label for="newRoleDescription" class="text-xs font-bold text-slate-700">Description</label><textarea id="newRoleDescription" maxlength="160" class="w-full mt-1 mb-5 border border-slate-200 rounded-lg p-3 text-sm" rows="3" placeholder="What is this role for?"></textarea>
                <div class="flex justify-end gap-3"><button type="button" id="cancelModal" class="border border-slate-200 rounded-lg px-4 py-2 text-sm font-semibold">Cancel</button><button type="submit" class="bg-brand-600 text-white rounded-lg px-4 py-2 text-sm font-bold">Create Role</button></div>
            </form>
        </div>
    </div> -->

</body>

</html>