<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(): View
    {
        $players = Player::orderBy('number')->get();

        return view('players.index', compact('players'));
    }

    public function create(): View
    {
        return view('players.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:100'],
            'number'   => ['required', 'integer', 'min:1', 'max:99', 'unique:players'],
            'height'   => ['nullable', 'string', 'max:100'],
            'weight'   => ['nullable', 'string', 'max:100'],
            'status'   => ['nullable', 'boolean'],
        ]);

        Player::create($validated);

        return redirect()->route('players.index')->with('status', 'player-created');
    }

    public function show(Player $player): View
    {
        return view('players.show', compact('player'));
    }

    public function edit(Player $player): View
    {
        return view('players.edit', compact('player'));
    }

    public function update(Request $request, Player $player): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:100'],
            'number'   => ['required', 'integer', 'min:1', 'max:99', 'unique:players,number,' . $player->id],
            'height'   => ['nullable', 'string', 'max:100'],
            'weight'   => ['nullable', 'string', 'max:100'],
            'status'   => ['nullable', 'boolean'],
        ]);

        $player->update($validated);

        return redirect()->route('players.index')->with('status', 'player-updated');
    }

    public function destroy(Player $player): RedirectResponse
    {
        $player->delete();

        return redirect()->route('players.index')->with('status', 'player-deleted');
    }
}
