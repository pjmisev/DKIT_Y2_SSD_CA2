<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
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
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = $request->boolean('status', true);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('status', 'user-created');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
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
