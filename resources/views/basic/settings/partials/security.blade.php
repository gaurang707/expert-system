<section class="panel active" id="panel-profile" id="panel-security" role="tabpanel" aria-labelledby="tab-security">

    <div class="mb-7">
        <h2 class="text-xl font-bold text-slate-900">Password & security</h2>
        <p class="text-sm text-slate-500 mt-1">Use a strong password to keep your account safe.</p>
    </div>
    <form method="post" action="{{ route('settings.security') }}" data-form="security" class="space-y-5 max-w-xl">
        @csrf
        @method('patch')
        <div>
            <label class="field-label" for="currentPassword">Current password</label>
            <input class="field" type="password" name="current_password" id="currentPassword" autocomplete="current-password" />
            @error('current_password')
            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="field-label" for="newPassword">New password</label>
            <input class="field" type="password" name="password" id="newPassword" autocomplete="new-password" minlength="8" />
            <p class="text-xs text-slate-400 mt-2">Use at least 8 characters.</p>
            @error('password')
            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="field-label" for="confirmPassword">Confirm new password</label>
            <input class="field" type="password" name="password_confirmation" id="confirmPassword" autocomplete="new-password" minlength="8" />
            @error('password_confirmation')
            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="rounded-xl bg-amber-50 border border-amber-100 p-4 flex gap-3">
            <span aria-hidden="true">🔒</span>
            <p class="text-sm text-amber-900">Never share your password with anyone. This demo does not send or save passwords.</p>
        </div>
        <div class="border-t border-slate-100 pt-6 flex justify-end gap-3">
            <a href="{{ route('settings.index', ['tab' => 'security']) }}"
                class="rounded-lg bg-gray-100 px-5 py-3">
                Reset
            </a>

            <button type="submit" class="rounded-lg bg-blue-600 hover:bg-blue-700 px-5 py-3 text-white font-semibold text-sm shadow-sm">Update password</button>
        </div>
    </form>
</section>