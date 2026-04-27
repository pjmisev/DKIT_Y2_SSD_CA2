<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Team::withCount('users')->orderBy('name')->get();

        return view('admin.teams.index', compact('teams'));
    }

    public function create(): View
    {
        return view('admin.teams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:teams'],
            'theme_color' => ['required', 'string', 'max:7', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        Team::create($validated);

        return redirect()->route('admin.teams.index')->with('status', 'team-created');
    }

    public function edit(Team $team): View
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:teams,name,' . $team->id],
            'theme_color' => ['required', 'string', 'max:7', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        $team->update($validated);

        return redirect()->route('admin.teams.index')->with('status', 'team-updated');
    }

    public function destroy(Team $team): RedirectResponse
    {
        // Check if team has users or profiles before deleting
        if ($team->users()->count() > 0 || $team->profiles()->count() > 0) {
            return redirect()->route('admin.teams.index')
                ->with('status', 'team-has-members');
        }

        $team->delete();

        return redirect()->route('admin.teams.index')->with('status', 'team-deleted');
    }
}
