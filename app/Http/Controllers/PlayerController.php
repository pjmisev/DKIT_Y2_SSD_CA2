<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Management;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlayerController extends Controller
{
    /**
     * User IDs already linked to any entity, optionally excluding one user ID
     * (used on edit so the current link stays selectable).
     */
    private function takenUserIds(?int $exceptUserId = null): array
    {
        return collect([
            Player::whereNotNull('linked_to')->pluck('linked_to'),
            Coach::whereNotNull('linked_to')->pluck('linked_to'),
            Management::whereNotNull('linked_to')->pluck('linked_to'),
        ])->flatten()->unique()->reject(fn ($id) => $id === $exceptUserId)->values()->all();
    }

    public function index(Request $request): View
    {
        $query = Player::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($position = $request->input('position')) {
            $query->where('position', $position);
        }

        if ($health = $request->input('health_status')) {
            $query->where('health_status', $health);
        }

        if ($team = $request->input('team')) {
            $query->where('team', 'like', "%{$team}%");
        }

        $players = $query->orderBy('name')->get();

        return view('players.index', [
            'players'        => $players,
            'positions'      => Player::POSITIONS,
            'healthStatuses' => Player::HEALTH_STATUSES,
        ]);
    }

    public function create(): View
    {
        return view('players.create', [
            'positions'      => Player::POSITIONS,
            'healthStatuses' => Player::HEALTH_STATUSES,
            'users'          => User::whereNotIn('id', $this->takenUserIds())->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'jersey_number' => ['nullable', 'integer', 'min:0', 'max:99'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'position'      => ['nullable', 'string', 'max:100'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'dominant_hand' => ['nullable', Rule::in(['left', 'right'])],
            'height_cm'     => ['nullable', 'integer', 'min:100', 'max:250'],
            'weight_kg'     => ['nullable', 'integer', 'min:30', 'max:200'],
            'health_status' => ['required', Rule::in(Player::HEALTH_STATUSES)],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'team'          => ['nullable', 'string', 'max:255'],
            'notes'         => ['nullable', 'string'],
            'linked_to'     => ['nullable', 'exists:users,id', function ($_, $value, $fail) {
                if (!$value) return;
                $taken = Player::where('linked_to', $value)->exists()
                      || Coach::where('linked_to', $value)->exists()
                      || Management::where('linked_to', $value)->exists();
                if ($taken) {
                    $fail('This user is already linked to another player, coach, or management member.');
                }
            }],
        ]);

        $validated['created_by'] = Auth::id();

        Player::create($validated);

        return redirect()->route('players.index')->with('status', 'player-created');
    }

    public function show(Player $player): View
    {
        return view('players.show', compact('player'));
    }

    public function edit(Player $player): View
    {
        return view('players.edit', [
            'player'         => $player,
            'positions'      => Player::POSITIONS,
            'healthStatuses' => Player::HEALTH_STATUSES,
            'users'          => User::whereNotIn('id', $this->takenUserIds($player->linked_to))->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Player $player): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'jersey_number' => ['nullable', 'integer', 'min:0', 'max:99'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'position'      => ['nullable', 'string', 'max:100'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'dominant_hand' => ['nullable', Rule::in(['left', 'right'])],
            'height_cm'     => ['nullable', 'integer', 'min:100', 'max:250'],
            'weight_kg'     => ['nullable', 'integer', 'min:30', 'max:200'],
            'health_status' => ['required', Rule::in(Player::HEALTH_STATUSES)],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'team'          => ['nullable', 'string', 'max:255'],
            'notes'         => ['nullable', 'string'],
            'linked_to'     => ['nullable', 'exists:users,id', function ($attr, $value, $fail) use ($player) {
                if (!$value) return;
                $taken = Player::where('linked_to', $value)->where('id', '!=', $player->id)->exists()
                      || Coach::where('linked_to', $value)->exists()
                      || Management::where('linked_to', $value)->exists();
                if ($taken) {
                    $fail('This user is already linked to another player, coach, or management member.');
                }
            }],
        ]);

        $player->update($validated);

        return redirect()->route('players.show', $player)->with('status', 'player-updated');
    }

    public function destroy(Player $player): RedirectResponse
    {
        $player->delete();

        return redirect()->route('players.index')->with('status', 'player-deleted');
    }
}
