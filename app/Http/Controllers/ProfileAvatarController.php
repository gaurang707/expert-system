<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

class ProfileAvatarController extends Controller
{
    public function edit(Request $request): View
    {
        return view('basic.profile.avatar', [
            'user' => $request->user(),
        ]);
    }

     public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'avatar' => [
                'required',
                File::image()
                    ->max('2mb'),
            ],
        ], [
            'avatar.required' => 'Please select a profile image.',
        ]);

        $user = $request->user();

         // Store uploaded image
        $path = $validated['avatar']->store(
            'avatars',
            'public'
        );

        // Keep old image path
        $oldAvatar = $user->avatar;

        // Save new path in users table
        $user->avatar = $path;
        $user->save();

        // Remove old image after successful update
        if ($oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }

         return redirect()
            ->route('profile.avatar.edit')
            ->with('success', 'Profile image updated successfully.');
    }
}
