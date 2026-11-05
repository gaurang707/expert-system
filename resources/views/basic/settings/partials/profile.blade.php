<section class="panel active" id="panel-profile" role="tabpanel" aria-labelledby="tab-profile">
    <div class="mb-7">
        <h2 class="text-xl font-bold text-slate-900">Profile information</h2>
        <p class="text-sm text-slate-500 mt-1">Update your photo and basic personal details.</p>
    </div>
    <form method="post" action="{{ route('settings.profile') }}" enctype="multipart/form-data" data-form="profile" class="space-y-6">
        @csrf
        @method('patch')
        <div class="flex flex-wrap items-center gap-5 pb-6 border-b border-slate-100">
            <div id="avatarPreview" class="w-20 h-20 rounded-full bg-indigo-100 text-indigo-700 font-bold text-2xl flex items-center justify-center overflow-hidden">
                @if($user->avatar)
                <img
                    src="{{ Storage::disk('public')->url($user->avatar) }}"
                    alt="Profile Image"
                    class="w-24 h-24 rounded-full object-cover border">
                @else
                <div class="w-24 h-24 rounded-full bg-gray-200
                        flex items-center justify-center
                        text-3xl text-gray-500">
                    {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                </div>
                @endif
            </div>
            <div>
                <label for="avatar" class="inline-flex cursor-pointer border border-slate-300 rounded-lg px-4 py-2 text-sm font-semibold hover:bg-slate-50">Change photo</label>
                <input id="avatar" name="avatar" type="file" accept="image/png,image/jpeg,image/webp" class="hidden">
                <p class="text-xs text-slate-400 mt-2">JPG, PNG, or WebP. Max 2 MB.</p>

                @error('avatar')
                <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="grid sm:grid-cols-2 gap-5">
            <div>
                <label class="field-label" for="fullName">Full name</label>
                <input class="field" id="fullName" name="name" value="{{ old('name', $user->name) }}" minlength="3" />
                @error('name')
                <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="field-label" for="displayName">Display name</label>
                <input class="field" id="displayName" name="display_name" value="{{ old('display_name', $user->display_name) }}" />
                @error('display_name')
                <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div>
            <label class="field-label" for="email">Email address</label>
            <input class="field" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" />
            <p class="text-xs text-slate-400 mt-2">Used for important account updates and notifications.</p>
            @error('email')
            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="field-label" for="bio">Short bio</label>
            <textarea class="field min-h-[105px] resize-y" id="bio" name="bio" placeholder="Tell us a little about yourself">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')
            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-slate-100 pt-6 flex justify-end gap-3">

             <a href="{{ route('settings.index', ['tab' => 'profile']) }}"
                class="rounded-lg bg-gray-100 px-5 py-3">
                Reset
            </a>

            <button type="submit" class="rounded-lg bg-blue-600 hover:bg-blue-700 px-5 py-3 text-white font-semibold text-sm shadow-sm">Save profile</button>

        </div>
    </form>
</section>