<x-layouts::app :title="__('Register User')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="w-full max-w-xl mx-auto bg-white border border-slate-100 rounded-2xl shadow-sm p-6 sm:p-8">

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm font-medium text-emerald-800 border border-emerald-200">
                {{ session('success') }}
            </div>
            @endif

            <!-- Error Message -->
            @if ($errors->any())
            <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50/50 p-4 shadow-sm animate-fade-in">
                <div class="flex items-start gap-3">
                    <!-- Warning Alert Icon -->
                    <svg class="h-5 w-5 shrink-0 text-rose-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>

                    <div class="space-y-1">
                        <h3 class="text-sm font-semibold text-rose-800">Please correct the following errors:</h3>
                        <!-- List of All Dynamic Errors -->
                        <ul class="list-disc pl-4 text-xs font-medium text-rose-700 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Header -->
            <div class="mb-6 space-y-1">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Register New User</h2>

            </div>


            <!-- Form Container -->
            <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                @csrf
                <!-- Name Field -->
                <div class="space-y-1.5">
                    <label for="name" class="text-sm font-semibold text-slate-700">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="John Doe"
                        value="{{ old('name') }}"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100">
                    @error('name')
                    <div class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                        <svg class="h-4 w-4 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>


                <!-- Email Field -->
                <div class="space-y-1.5">
                    <label for="email" class="text-sm font-semibold text-slate-700">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="you@example.com"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                        value="{{ old('email') }}">
                    @error('email')
                    <div class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                        <svg class="h-4 w-4 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror

                </div>

                <!-- Password Field -->

                <div class="space-y-1.5">
                    <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="*********"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                        value="{{ old('password') }}">
                    @error('password')
                    <div class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                        <svg class="h-4 w-4 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror

                </div>

                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        placeholder="*********"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                        value="">
                    @error('password_confirmation')
                    <div class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                        <svg class="h-4 w-4 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror

                </div>

                <!-- Submit Button Block -->
                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-200 cursor-pointer">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>