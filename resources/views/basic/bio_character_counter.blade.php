<x-layouts::app :title="__('Bio Character Counter')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl border border-slate-100 bg-white p-6 shadow-sm max-w-xl mx-auto">
        <!-- Header/Title -->
        <div class="space-y-1">
            <label for="profile-bio" class="text-sm font-semibold text-slate-700">Profile Bio</label>
            <p class="text-xs text-slate-500">Brief description for your profile. Maximum 160 characters.</p>
        </div>

        <form action="{{ route('bio-character-counter-post') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            <!-- Styled Textarea Container -->
            <div class="relative">
                <textarea
                    name="profile-bio"
                    id="profile-bio"
                    rows="4"
                    placeholder="Tell us about yourself..."

                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100 resize-none">{{ old('profile-bio') }}</textarea>
            </div>

            <label id="char-count">0</label>

            <!-- Optional: Laravel Error Message Handling -->
            @error('profile-bio')
            <p class="text-xs font-medium text-rose-500 mt-1">{{ $message }}</p>
            @enderror

            <!-- Actions Row -->
            <div class="flex items-center justify-end border-t border-slate-100 pt-4">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            const bio = document.getElementById('profile-bio');
            const countDisplay = document.getElementById('char-count');

            function updateCount() {
                let length = bio.value.length;
                countDisplay.textContent = length;

                if (length > 160) {
                    countDisplay.parentElement.classList.remove('text-slate-400');
                    countDisplay.parentElement.classList.add('text-amber-500');
                } else {
                    countDisplay.parentElement.classList.remove('text-amber-500');
                    countDisplay.parentElement.classList.add('text-slate-400');
                }
            }

            // Listen for input events (typing, pasting, deleting)
            bio.addEventListener('input', updateCount);
            updateCount();
        });
    </script>
</x-layouts::app>