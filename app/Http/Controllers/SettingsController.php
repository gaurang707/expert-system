<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreferencesRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\SecurityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'profile');
        // Only allow valid tabs
        if (! in_array($tab, ['profile', 'security', 'preferences'], true)) {
            $tab = 'profile';
        }


        //dd($request->all());

        $user = auth()->user();

        return view('basic.settings.index', compact('user', 'tab'));
    }

    public function profile(ProfileRequest $request)
    {
        $user = $request->user();
        $validated = $request->safe()->except('avatar');

        //dd( $request->all());

        if ($request->hasFile('avatar')) {
            $oldAvatar = $user->avatar;
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);
        if (isset($oldAvatar) && $oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }

        return redirect()
            ->route('settings.index', ['tab' => 'profile'])
            ->with('success', 'Profile Updated successfully');
    }

    public function security(SecurityRequest $request)
    {
        $user  = $request->user();
        $validated = $request->validated();
        $user->password = Hash::make($validated['password']);
        $user->save();
        return redirect()
            ->route('settings.index', ['tab' => 'security'])
            ->with('success', 'Password updated successfully.');
    }

    public function preferences(PreferencesRequest $request)
    {
        // dd($request->validated());
        $request->user()->update($request->validated());
        return redirect()
            ->route('settings.index', ['tab' => 'preferences'])
            ->with('success', 'Preferences updated successfully.');
    }
}
