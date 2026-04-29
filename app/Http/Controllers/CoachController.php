<?php

namespace App\Http\Controllers;

use App\Models\CoachInfo;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CoachController extends Controller
{
    public function index(Request $request): View
    {
        $query = Profile::where('profileable_type', CoachInfo::class)
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

        return view('coaches.index', [
            'profiles' => $profiles,
            'roles'    => CoachInfo::ROLES,
        ]);
    }

    public function create(): View
    {
        return view('coaches.create', [
            'users' => User::doesntHave('profile')->orderBy('name')->get(),
            'roles' => CoachInfo::ROLES,
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

            // Coach-specific fields
            'role'          => ['nullable', Rule::in(CoachInfo::ROLES)],
        ]);

        // Create the user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'coach',
            'salary'   => $validated['salary'] ?? null,
            'status'   => $request->boolean('status', true),
        ]);

        // Create the coach info
        $coachInfo = CoachInfo::create([
            'role' => $validated['role'] ?? null,
        ]);

        // Create the profile
        $profileData = [
            'user_id'          => $user->id,
            'profileable_type' => CoachInfo::class,
            'profileable_id'   => $coachInfo->id,
            'team'             => $validated['team'] ?? null,
            'nationality'      => $validated['nationality'] ?? null,
            'date_of_birth'    => $validated['date_of_birth'] ?? null,
            'notes'            => $validated['notes'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $profileData['image'] = $request->file('image')->store('images/coaches', 'public');
        }

        Profile::create($profileData);

        return redirect()->route('coaches.index')->with('status', 'coach-created');
    }

    public function show(Profile $profile): View
    {
        abort_if($profile->profileable_type !== CoachInfo::class, 404);

        return view('coaches.show', compact('profile'));
    }

    public function edit(Profile $profile): View
    {
        abort_if($profile->profileable_type !== CoachInfo::class, 404);

        return view('coaches.edit', [
            'coach' => $profile,
            'roles' => CoachInfo::ROLES,
        ]);
    }

    public function update(Request $request, Profile $profile): RedirectResponse
    {
        abort_if($profile->profileable_type !== CoachInfo::class, 404);

        $user = $profile->user;
        $coachInfo = $profile->profileable;

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

            // Coach-specific fields
            'role'          => ['nullable', Rule::in(CoachInfo::ROLES)],
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

        // Update coach info
        $coachInfo->update([
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
            $profileData['image'] = $request->file('image')->store('images/coaches', 'public');
        }

        $profile->update($profileData);

        return redirect()->route('coaches.show', $profile)->with('status', 'coach-updated');
    }

    public function destroy(Profile $profile): RedirectResponse
    {
        abort_if($profile->profileable_type !== CoachInfo::class, 404);

        if ($profile->image) {
            Storage::disk('public')->delete($profile->image);
        }

        $user = $profile->user;

        $profile->profileable()->delete();
        $profile->delete();
        $user->delete();

        return redirect()->route('coaches.index')->with('status', 'coach-deleted');
    }
}
