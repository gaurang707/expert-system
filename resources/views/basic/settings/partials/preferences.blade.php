<section class="panel active" id="panel-preferences" role="tabpanel" aria-labelledby="tab-preferences">
    <div class="mb-7">
        <h2 class="text-xl font-bold text-slate-900">Preferences</h2>
        <p class="text-sm text-slate-500 mt-1">Choose how the application should work for you.</p>
    </div>
    <form method="post" action="{{ route('settings.preferences') }}" data-form="preferences" class="space-y-7">
        @csrf
        @method('patch')
        @php
        $timezones = ['Asia/Kolkata', 'America/Denver', 'America/New_York', 'Europe/London'];
        $languages = ['english', 'hindi', 'gujarati'];
        @endphp

        <div class="grid sm:grid-cols-2 gap-5">
            <div>
                <label class="field-label" for="timezone">Timezone</label>
                <select class="field" id="timezone" name="timezone">
                    <option value="">--Select Timezone---</option>
                    @foreach ($timezones as $timezone)
                    <option value="{{ $timezone }}" @selected(old('timezone', $user->timezone) === $timezone)>{{ $timezone }}</option>
                    @endforeach

                </select>
                @error('timezone')
                <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="field-label" for="language">Language</label>
                <select class="field" id="language" name="language">
                    <option value="">---Select Language---</option>
                    @foreach ($languages as $language)
                    <option value="{{ $language }}" @selected(old('language', $user->language) === $language)>{{ $language }}</option>
                    @endforeach
                </select>
                @error('language')
                <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="border-t border-slate-100 pt-6">
            <h3 class="text-sm font-bold text-slate-900 mb-1">Notifications</h3>
            <p class="text-sm text-slate-500 mb-5">Manage the updates you receive.</p>
            <div class="space-y-5">
                <div>
                    <label class="flex justify-between items-center gap-4 cursor-pointer">
                        <span>
                            <span class="block font-semibold text-sm text-slate-700">Email notifications</span>
                            <span class="text-xs text-slate-500">Receive important updates by email.</span>
                        </span>
                        <span class="relative">
                            <input type="hidden" name="email_notification" value="0">
                            <input
                                type="checkbox"
                                class="sr-only"
                                name="email_notification"
                                value="1"
                                @checked(old('email_notification', $user->email_notification))
                            >
                            <span class="toggle block"></span>
                        </span>
                    </label>
                    @error('email_notification')
                    <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="flex justify-between items-center gap-4 cursor-pointer">
                        <span>
                            <span class="block font-semibold text-sm text-slate-700">Task reminders</span>
                            <span class="text-xs text-slate-500">Get reminders for upcoming tasks.</span>
                        </span>
                        <span class="relative">
                            <input type="hidden" name="task_reminder" value="0">
                            <input
                                type="checkbox"
                                class="sr-only"
                                name="task_reminder"
                                value="1"
                                @checked(old('task_reminder', $user->task_reminder))
                            >
                            <span class="toggle block"></span>
                        </span>
                    </label>
                    @error('task_reminder')
                    <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex justify-between items-center gap-4 cursor-pointer">
                        <span>
                            <span class="block font-semibold text-sm text-slate-700">Product announcements</span>
                            <span class="text-xs text-slate-500">Hear about new features and improvements.</span>
                        </span>
                        <span class="relative">
                            <input type="hidden" name="product_announcement" value="0">
                            <input
                                type="checkbox"
                                class="sr-only"
                                name="product_announcement"
                                value="1"
                                @checked(old('product_announcement', $user->product_announcement))
                            >

                            <span class="toggle block"></span>
                        </span>
                    </label>
                    @error('product_announcement')
                    <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="border-t border-slate-100 pt-6 flex justify-end gap-3">

            <a href="{{ route('settings.index', ['tab' => 'preferences']) }}"
                class="rounded-lg bg-gray-100 px-5 py-3">
                Reset
            </a>
            <button type="submit" class="rounded-lg bg-blue-600 hover:bg-blue-700 px-5 py-3 text-white font-semibold text-sm shadow-sm">Save preferences</button>
        </div>
    </form>
</section>