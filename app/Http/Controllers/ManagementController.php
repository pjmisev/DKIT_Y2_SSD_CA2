<?php

namespace App\Http\Controllers;

use App\Models\ManagementInfo;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = Profile::where('profileable_type', ManagementInfo::class)
            ->with(['user', 'profileable']);

        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($team = $request->input('team')) {
            $query->where('team', 'like', "%{$team}%");
        }

        if ($nationality = $request->input('nationality')) {
            $query->where('nationality', 'like', "%{$nationality}%");
        }

        $profiles = $query->orderBy('id')->get();

        return view('management.index', [
            'profiles' => $profiles,
            'roles'    => ManagementInfo::ROLES,
        ]);
    }

    public function create(): View
    {
        return view('management.create', [
            'users' => User::doesntHave('profile')->orderBy('name')->get(),
            'roles' => ManagementInfo::ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // User fields
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'confirmed', Password::defaults()],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'status'        => ['boolean'],

            // Profile fields
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'notes'         => ['nullable', 'string'],
            'image'         => ['nullable', 'image', 'max:2048'],

            // Management-specific fields
            'role'          => ['nullable', Rule::in(ManagementInfo::ROLES)],
        ]);

        // Create the user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'management',
            'salary'   => $validated['salary'] ?? null,
            'status'   => $request->boolean('status', true),
        ]);

        // Create the management info
        $managementInfo = ManagementInfo::create([
            'role' => $validated['role'] ?? null,
        ]);

        // Create the profile
        $profileData = [
            'user_id'          => $user->id,
            'profileable_type' => ManagementInfo::class,
            'profileable_id'   => $managementInfo->id,
            'team'             => $validated['team'] ?? null,
            'nationality'      => $validated['nationality'] ?? null,
            'date_of_birth'    => $validated['date_of_birth'] ?? null,
            'notes'            => $validated['notes'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $profileData['image'] = $request->file('image')->store('images/management', 'public');
        }

        Profile::create($profileData);

        return redirect()->route('management.index')->with('status', 'management-created');
    }

    public function show(Profile $profile): View
    {
        abort_if($profile->profileable_type !== ManagementInfo::class, 404);

        return view('management.show', compact('profile'));
    }

    public function edit(Profile $profile): View
    {
        abort_if($profile->profileable_type !== ManagementInfo::class, 404);

        return view('management.edit', [
            'profile' => $profile,
            'roles'   => ManagementInfo::ROLES,
        ]);
    }

    public function update(Request $request, Profile $profile): RedirectResponse
    {
        abort_if($profile->profileable_type !== ManagementInfo::class, 404);

        $user = $profile->user;
        $managementInfo = $profile->profileable;

        $validated = $request->validate([
            // User fields
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password'      => ['nullable', 'confirmed', Password::defaults()],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'status'        => ['boolean'],

            // Profile fields
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'notes'         => ['nullable', 'string'],
            'image'         => ['nullable', 'image', 'max:2048'],

            // Management-specific fields
            'role'          => ['nullable', Rule::in(ManagementInfo::ROLES)],
        ]);

        // Update user
        $userData = [
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'salary' => $validated['salary'] ?? null,
            'status' => $request->boolean('status'),
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Update management info
        $managementInfo->update([
            'role' => $validated['role'] ?? null,
        ]);

        // Update profile
        $profileData = [
            'team'          => $validated['team'] ?? null,
            'nationality'   => $validated['nationality'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'notes'         => $validated['notes'] ?? null,
        ];

        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }
            $profileData['image'] = $request->file('image')->store('images/management', 'public');
        }

        $profile->update($profileData);

        return redirect()->route('management.show', $profile)->with('status', 'management-updated');
    }

    public function destroy(Profile $profile): RedirectResponse
    {
        abort_if($profile->profileable_type !== ManagementInfo::class, 404);

        if ($profile->image) {
            Storage::disk('public')->delete($profile->image);
        }

        $user = $profile->user;

        $profile->profileable()->delete();
        $profile->delete();
        $user->delete();

        return redirect()->route('management.index')->with('status', 'management-deleted');
    }
}
