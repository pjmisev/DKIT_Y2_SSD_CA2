<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(): View
    {
        $players = Player::orderBy('name')->get();

        return view('players.index', compact('players'));
    }

    public function create(): View
    {
        return view('players.create', [
            'positions'     => Player::POSITIONS,
            'healthStatuses' => Player::HEALTH_STATUSES,
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
