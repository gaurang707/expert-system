<x-layouts::app :title="__('Profile')">
    <div class="max-w-xl mx-auto mt-10 bg-white
            border border-gray-200 rounded-xl p-6">

        <h2 class="text-xl font-bold mb-6">
            Update Profile Image
        </h2>

        @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <!-- Current avatar -->
        <div class="flex items-center gap-4 mb-6">

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

            <div>
                <p class="font-semibold">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Upload Form -->
        <form
            method="POST"
            action="{{ route('profile.avatar.update') }}"
            enctype="multipart/form-data">
            @csrf

            <label class="block text-sm font-medium mb-2">
                Select Profile Image
            </label>

            <input
                type="file"
                name="avatar"
                accept="image/png,image/jpeg,image/webp"
                class="block w-full border border-gray-300
                   rounded-lg p-2">

            @error('avatar')
            <p class="text-sm text-red-600 mt-2">
                {{ $message }}
            </p>
            @enderror

            <p class="text-xs text-gray-500 mt-2">
                Supported: JPG, PNG, WebP. Maximum size: 2 MB.
            </p>

            <button
                type="submit"
                class="mt-5 bg-blue-600 text-white px-5 py-2
                   rounded-lg hover:bg-blue-700">
                Upload Image
            </button>
        </form>

    </div>
</x-layouts::app>