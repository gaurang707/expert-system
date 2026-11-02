<x-layouts::app :title="__('Create user')">


  <!-- ========================================== -->
  <!-- 2. USERS CREATE FORM                        -->
  <!-- ========================================== -->
  <div class="max-w-2xl mx-auto mb-16">
    <div class="mb-6">
      <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Users
      </a>
      <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Create User</h2>
      <p class="text-sm text-gray-500">Add a brand new user profile.</p>
    </div>

    <form method="post" action="{{ route('users.store') }}" class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8 space-y-5">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Jane Doe" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition" />
        @error('name')
        <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="jane.doe@example.com" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition" />
        @error('email')
        <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
        @enderror
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input type="password" name="password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition" />
          @error('password')
          <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
          <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition" />
          @error('password_confirmation')
          <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
          <select name="role_id" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition">
            <option value="">---Select Role---</option>
            @foreach ($roles as $role)
            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
            @endforeach
          </select>
          @error('role_id')
          <p class="text-xs font-medium text-red-600 mt-0.5">{{ $message }}</p>
          @enderror
        </div>
        <div>
          @php
          $status = old('status', '');
          @endphp
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition">
            <option value="">---Select status---</option>
            <option value="active" @if($status=='active' ) selected @endif>Active</option>
            <option value="inactive" @if($status=='inactive' ) selected @endif>Inactive</option>
          </select>
        </div>
      </div>

      <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
        <a href="{{ route('users.index') }}" class="px-4 py-2.5 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl transition">
          Cancel
        </a>
        <button type="submit" class="px-5 py-2.5 bg-black hover:bg-neutral-800 text-white text-sm font-medium rounded-xl transition">
          Create User
        </button>
      </div>
    </form>
  </div>
</x-layouts::app>