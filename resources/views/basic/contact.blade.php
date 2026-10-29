<x-layouts::app :title="__('Contact')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="w-full max-w-xl mx-auto bg-white border border-slate-100 rounded-2xl shadow-sm p-6 sm:p-8">

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm font-medium text-emerald-800 border border-emerald-200">
                {{ session('success') }}
            </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
            <div class="mb-4 rounded-lg bg-rose-50 p-4 text-sm font-medium text-rose-800 border border-rose-200">
                {{ session('error') }}
            </div>
            @endif

            <!-- Header -->
            <div class="mb-6 space-y-1">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Get in touch</h2>
                <p class="text-sm text-slate-500">Have a question or feedback? We would love to hear from you.</p>
            </div>


            <!-- Form Container -->
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
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

                <!-- Subject Field -->
                <div class="space-y-1.5">
                    <label for="subject" class="text-sm font-semibold text-slate-700">Subject</label>
                    <input
                        type="text"
                        name="subject"
                        id="subject"
                        placeholder="How can we help you?"
                        value="{{ old('subject') }}"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100">

                    @error('subject')
                    <div class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                        <svg class="h-4 w-4 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Message Field -->
                <div class="space-y-1.5">
                    <label for="message" class="text-sm font-semibold text-slate-700">Message</label>
                    <textarea
                        name="message"
                        id="message"
                        rows="5"
                        placeholder="Write your message here..."
                        value="{{ old('message') }}"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100 resize-y min-h-[120px]"></textarea>

                    @error('message')
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