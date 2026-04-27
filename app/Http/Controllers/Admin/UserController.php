<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('team')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $teams = Team::orderBy('name')->get();

        return view('admin.users.create', compact('teams'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => ['required', 'string', 'in:admin,coach,player,staff'],
            'position' => ['nullable', 'string', 'max:255'],
            'salary'   => ['required', 'integer', 'min:0'],
            'status'   => ['boolean'],
            'team_id'  => ['nullable', 'integer', 'exists:teams,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = $request->boolean('status', true);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('status', 'user-created');
    }

    public function edit(User $user): View
    {
        $teams = Team::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'teams'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role'     => ['required', 'string', 'in:admin,coach,player,staff'],
            'position' => ['nullable', 'string', 'max:255'],
            'salary'   => ['required', 'integer', 'min:0'],
            'status'   => ['boolean'],
            'team_id'  => ['nullable', 'integer', 'exists:teams,id'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['status'] = $request->boolean('status');

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('status', 'user-updated');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'user-deleted');
    }
}
