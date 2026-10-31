<x-layouts::app :title="__('Counter Reset')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center justify-center min-h-screen bg-gray-50 p-6">
            <div class="w-full max-w-md bg-white border border-gray-200 rounded-2xl shadow-sm p-8">

                <!-- Success Banner -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl">
                    <p class="font-bold text-green-900 mb-2">{{ session('success') }}</p>
                    <div class="text-xs space-y-1 text-green-700 bg-white/50 p-3 rounded-lg border border-green-100">
                        <div><strong>First Name:</strong> {{ session('first_name') }}</div>
                        <div><strong>Last Name:</strong> {{ session('last_name') }}</div>
                    </div>
                </div>
                @endif
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Personal Information</h2>
                    <p class="text-sm text-gray-500 mt-1">Please enter your legal name as it appears on your ID.</p>
                </div>

                <!-- Form -->
                <form id="name-form" class="space-y-6" action="{{ route('name-preview-store') }}" method="post">
                    @csrf
                    <!-- Grid Container for Names -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div class="flex flex-col gap-1.5">
                            <label for="first-name" class="text-sm font-semibold text-gray-700">First name</label>
                            <input
                                value="{{ old('first-name') }}"
                                type="text"
                                id="first-name"
                                name="first-name"
                                placeholder="Jane"

                                class="w-full px-3 py-2 bg-white border rounded-lg text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:outline-none transition-all
            @error('first-name') border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 @else border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror" />

                            @error('first-name')
                            <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="flex flex-col gap-1.5">
                            <label for="last-name" class="text-sm font-semibold text-gray-700">Last name</label>
                            <input
                                value="{{ old('first-name') }}"
                                type="text"
                                id="last-name"
                                name="last-name"
                                placeholder="Doe"

                                class="w-full px-3 py-2 bg-white border rounded-lg text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:outline-none transition-all
            @error('last-name') border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 @else border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 @enderror" />
                            @error('last-name')
                            <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
                            @enderror

                        </div>
                    </div>

                    <!-- Action Button -->
                    <button
                        type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 active:bg-blue-800 transition-colors cursor-pointer">
                        Save changes
                    </button>
                </form>
            </div>
        </div>


    </div>

  
</x-layouts::app>