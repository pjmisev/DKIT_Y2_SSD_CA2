<?php

namespace App\Http\Controllers;

use App\Models\PlayerInfo;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PlayerController extends Controller
{
    /**
     * Get users who can be assigned a player profile (users without any profile yet).
     */
    private function availableUsers(?int $exceptUserId = null): array
    {
        return User::whereDoesntHave('profile')
            ->when($exceptUserId, fn ($q) => $q->orWhere('id', $exceptUserId))
            ->orderBy('name')
            ->get()
            ->all();
    }

    public function index(Request $request): View
    {
        $query = Profile::where('profileable_type', PlayerInfo::class)
            ->with(['user', 'profileable']);

        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($position = $request->input('position')) {
            $query->whereHasMorph('profileable', [PlayerInfo::class], function ($q) use ($position) {
                $q->where('position', $position);
            });
        }

        if ($health = $request->input('health_status')) {
            $query->whereHasMorph('profileable', [PlayerInfo::class], function ($q) use ($health) {
                $q->where('health_status', $health);
            });
        }

        if ($team = $request->input('team')) {
            $query->where('team', 'like', "%{$team}%");
        }

        $profiles = $query->orderBy('id')->get();

        return view('players.index', [
            'profiles'       => $profiles,
            'positions'      => PlayerInfo::POSITIONS,
            'healthStatuses' => PlayerInfo::HEALTH_STATUSES,
        ]);
    }

    public function create(): View
    {
        return view('players.create', [
            'positions'      => PlayerInfo::POSITIONS,
            'healthStatuses' => PlayerInfo::HEALTH_STATUSES,
            'users'          => User::doesntHave('profile')->orderBy('name')->get(),
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

            // Player-specific fields
            'jersey_number' => ['nullable', 'integer', 'min:0', 'max:99'],
            'position'      => ['nullable', 'string', 'max:100'],
            'dominant_hand' => ['nullable', Rule::in(['left', 'right'])],
            'height_cm'     => ['nullable', 'integer', 'min:100', 'max:250'],
            'weight_kg'     => ['nullable', 'integer', 'min:30', 'max:200'],
            'health_status' => ['required', Rule::in(PlayerInfo::HEALTH_STATUSES)],
        ]);

        // Create the user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'player',
            'salary'   => $validated['salary'] ?? null,
            'status'   => $request->boolean('status', true),
        ]);

        // Create the player info
        $playerInfo = PlayerInfo::create([
            'jersey_number' => $validated['jersey_number'] ?? null,
            'position'      => $validated['position'] ?? null,
            'dominant_hand' => $validated['dominant_hand'] ?? null,
            'height_cm'     => $validated['height_cm'] ?? null,
            'weight_kg'     => $validated['weight_kg'] ?? null,
            'health_status' => $validated['health_status'],
        ]);

        // Create the profile linking user to player info
        $profileData = [
            'user_id'          => $user->id,
            'profileable_type' => PlayerInfo::class,
            'profileable_id'   => $playerInfo->id,
            'team'             => $validated['team'] ?? null,
            'nationality'      => $validated['nationality'] ?? null,
            'date_of_birth'    => $validated['date_of_birth'] ?? null,
            'notes'            => $validated['notes'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $profileData['image'] = $request->file('image')->store('images/players', 'public');
        }

        Profile::create($profileData);

        return redirect()->route('players.index')->with('status', 'player-created');
    }

    public function show(Profile $profile): View
    {
        // Ensure it's a player profile
        abort_if($profile->profileable_type !== PlayerInfo::class, 404);

        return view('players.show', compact('profile'));
    }

    public function edit(Profile $profile): View
    {
        abort_if($profile->profileable_type !== PlayerInfo::class, 404);

        return view('players.edit', [
            'player'         => $profile,
            'positions'      => PlayerInfo::POSITIONS,
            'healthStatuses' => PlayerInfo::HEALTH_STATUSES,
        ]);
    }

    public function update(Request $request, Profile $profile): RedirectResponse
    {
        abort_if($profile->profileable_type !== PlayerInfo::class, 404);

        $user = $profile->user;
        $playerInfo = $profile->profileable;

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

            // Player-specific fields
            'jersey_number' => ['nullable', 'integer', 'min:0', 'max:99'],
            'position'      => ['nullable', 'string', 'max:100'],
            'dominant_hand' => ['nullable', Rule::in(['left', 'right'])],
            'height_cm'     => ['nullable', 'integer', 'min:100', 'max:250'],
            'weight_kg'     => ['nullable', 'integer', 'min:30', 'max:200'],
            'health_status' => ['required', Rule::in(PlayerInfo::HEALTH_STATUSES)],
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

        // Update player info
        $playerInfo->update([
            'jersey_number' => $validated['jersey_number'] ?? null,
            'position'      => $validated['position'] ?? null,
            'dominant_hand' => $validated['dominant_hand'] ?? null,
            'height_cm'     => $validated['height_cm'] ?? null,
            'weight_kg'     => $validated['weight_kg'] ?? null,
            'health_status' => $validated['health_status'],
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
            $profileData['image'] = $request->file('image')->store('images/players', 'public');
        }

        $profile->update($profileData);

        return redirect()->route('players.show', $profile)->with('status', 'player-updated');
    }

    public function destroy(Profile $profile): RedirectResponse
    {
        abort_if($profile->profileable_type !== PlayerInfo::class, 404);

        if ($profile->image) {
            Storage::disk('public')->delete($profile->image);
        }

        $user = $profile->user;

        // Delete profile and player info (cascade handles profile)
        $profile->profileable()->delete();
        $profile->delete();

        // Optionally delete the user too
        $user->delete();

        return redirect()->route('players.index')->with('status', 'player-deleted');
    }
}
