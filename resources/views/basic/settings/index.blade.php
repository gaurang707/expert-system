<x-layouts::app :title="__('Settings')">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .tab-btn[aria-selected="true"] {
            background: #eff6ff;
            color: #1d4ed8;
            box-shadow: inset 3px 0 0 #2563eb;
        }

        .tab-btn[aria-selected="false"]:hover {
            background: #f8fafc;
            color: #334155;
        }

        .field {
            width: 100%;
            border: 1px solid #dbe2ec;
            border-radius: 10px;
            padding: 11px 13px;
            background: white;
            color: #0f172a;
            outline: none;
            transition: .2s;
        }

        .field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px #dbeafe;
        }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .panel {
            display: none;
        }

        .panel.active {
            display: block;
            animation: fadeIn .2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: .4;
                transform: translateY(5px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .toggle {
            position: relative;
            width: 42px;
            height: 24px;
            flex-shrink: 0;
            background: #cbd5e1;
            border-radius: 999px;
            transition: .2s;
        }

        .toggle::before {
            content: "";
            position: absolute;
            left: 3px;
            top: 3px;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: white;
            box-shadow: 0 1px 3px #64748b55;
            transition: transform .2s;
        }

        input:checked+.toggle {
            background: #2563eb;
        }

        input:checked+.toggle::before {
            transform: translateX(18px);
        }

        @media (max-width: 767px) {
            .tab-btn[aria-selected="true"] {
                box-shadow: inset 0 -3px 0 #2563eb;
            }
        }
    </style>
    <div class="mb-8">
        <div class="text-sm font-medium text-blue-600 mb-2">Dashboard <span class="text-slate-400 mx-1">/</span> Settings </div>
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">Account settings</h1>
        <p class="text-slate-500 mt-2 max-w-xl">Manage your personal details, account security, and notification preferences.</p>
    </div>

     <div class="space-y-4 max-w-xl mx-auto my-4">
            {{-- Success Message --}}
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

            {{-- Custom Session Error Message --}}
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
            {{-- Validation Errors Bag --}}
            @if ($errors->any())
            <div class="flex items-start justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold">Please fix the following errors:</p>
                        <ul class="mt-1 list-disc list-inside text-sm text-rose-700 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @endif
        </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden md:grid md:grid-cols-[240px_1fr] min-h-[520px]">
        <aside class="border-b md:border-b-0 md:border-r border-slate-200 bg-white p-3 md:p-5">
            <div class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-3 px-3 hidden md:block">Your account</div>

            <nav class="flex md:flex-col gap-1 overflow-x-auto" aria-label="Settings sections" role="tablist">
                <a href="{{ route('settings.index',  ['tab' => 'profile']) }}" class="tab-btn text-sm font-semibold whitespace-nowrap text-left rounded-lg px-4 py-3 flex items-center gap-3 w-full" type="button" id="tab-profile" role="tab" aria-controls="panel-profile" @if($tab=="profile" ) aria-selected="true" @else aria-selected="false" @endif data-tab="profile">
                    <span aria-hidden="true">◉</span> Profile
                </a>
                <a href="{{ route('settings.index',  ['tab' => 'security']) }}" class="tab-btn text-sm font-semibold whitespace-nowrap text-left rounded-lg px-4 py-3 flex items-center gap-3 w-full text-slate-500" type="button" id="tab-security" role="tab" aria-controls="panel-security" @if($tab=="security" ) aria-selected="true" @else aria-selected="false" @endif data-tab="security">
                    <span aria-hidden="true">◇</span> Security
                </a>
                <a href="{{ route('settings.index',  ['tab' => 'preferences']) }}" class="tab-btn text-sm font-semibold whitespace-nowrap text-left rounded-lg px-4 py-3 flex items-center gap-3 w-full text-slate-500" type="button" id="tab-preferences" role="tab" aria-controls="panel-preferences" @if($tab=="preferences" ) aria-selected="true" @else aria-selected="false" @endif data-tab="preferences">
                    <span aria-hidden="true">⚙</span> Preferences
                </a>
            </nav>


            <div class="hidden md:block mt-10 mx-3 rounded-xl bg-blue-50 p-4 border border-blue-100">
                <div class="font-semibold text-sm text-blue-900">Laravel practice UI</div>
                <p class="text-xs leading-relaxed text-blue-700 mt-1">Static frontend only. Connect each form to your controller when converting this page to Blade.</p>
            </div>
        </aside>
        <div class="p-5 sm:p-8 lg:p-10">
            <div id="alert" class="hidden mb-6 rounded-lg px-4 py-3 text-sm border" role="status" aria-live="polite"></div>

            @if($tab=="profile")
                @include('basic.settings.partials.profile')
            @elseif ($tab=="security")
                @include('basic.settings.partials.security')
            @elseif ($tab=="preferences")
                @include('basic.settings.partials.preferences')
            @endif            
            
        </div>
    </div>
    <p class="text-center text-xs text-slate-400 mt-6">Static HTML preview • No backend connected • Form submissions are not saved</p>


    <script>
        // const allowedTabs = ['profile', 'security', 'preferences'];
        // const tabs = [...document.querySelectorAll('[data-tab]')];
        // const panels = [...document.querySelectorAll('.panel')];
        // const alertBox = document.getElementById('alert');

        // function showTab(tab, updateUrl = true) {
        //     if (!allowedTabs.includes(tab)) tab = 'profile';
        //     tabs.forEach(button => button.setAttribute('aria-selected', String(button.dataset.tab === tab)));
        //     panels.forEach(panel => panel.classList.toggle('active', panel.id === `panel-${tab}`));
        //     alertBox.classList.add('hidden');
        //     if (updateUrl) history.replaceState(null, '', `#${tab}`);
        // }
        // tabs.forEach(button => button.addEventListener('click', () => showTab(button.dataset.tab)));
        // window.addEventListener('hashchange', () => showTab(location.hash.slice(1), false));
        // showTab(location.hash.slice(1), false);

        // function showMessage(message, error = false) {
        //     alertBox.textContent = message;
        //     alertBox.className = `mb-6 rounded-lg px-4 py-3 text-sm border ${error ? 'bg-red-50 border-red-200 text-red-700' : 'bg-blue-50 border-blue-200 text-blue-700'}`;
        //     alertBox.scrollIntoView({
        //         behavior: 'smooth',
        //         block: 'nearest'
        //     });
        // }
        // document.querySelectorAll('form[data-form]').forEach(form => form.addEventListener('submit', event => {
        //     event.preventDefault();
        //     if (!form.reportValidity()) return;
        //     if (form.dataset.form === 'security') {
        //         if (document.getElementById('newPassword').value !== document.getElementById('confirmPassword').value) {
        //             showMessage('New password and confirmation do not match.', true);
        //             return;
        //         }
        //         showMessage('Demo only: password is not changed. Connect this form to Laravel to save it.');
        //         form.reset();
        //     } else {
        //         showMessage('Demo only: changes are not saved. Connect this form to Laravel to persist the data.');
        //     }
        // }));
        // document.getElementById('avatar').addEventListener('change', event => {
        //     const file = event.target.files?.[0];
        //     if (!file) return;
        //     if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 2 * 1024 * 1024) {
        //         showMessage('Please choose a JPG, PNG or WebP image under 2 MB.', true);
        //         event.target.value = '';
        //         return;
        //     }
        //     const reader = new FileReader();
        //     reader.onload = () => {
        //         document.getElementById('avatarPreview').innerHTML = `<img alt="Selected avatar preview" class="w-full h-full object-cover">`;
        //         document.getElementById('avatarPreview').querySelector('img').src = reader.result;
        //     };
        //     reader.readAsDataURL(file);
        // });
    </script>
</x-layouts::app>