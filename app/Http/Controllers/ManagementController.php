<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = Management::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
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

        $members = $query->orderBy('name')->get();

        return view('management.index', compact('members'));
    }

    public function create(): View
    {
        return view('management.create', [
            'users' => User::orderBy('name')->get(),
            'roles' => Management::ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'role'          => ['nullable', Rule::in(Management::ROLES)],
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'notes'         => ['nullable', 'string'],
            'linked_to'     => ['nullable', 'exists:users,id'],
        ]);

        $validated['created_by'] = Auth::id();

        Management::create($validated);

        return redirect()->route('management.index')->with('status', 'management-created');
    }

    public function show(Management $management): View
    {
        return view('management.show', compact('management'));
    }

    public function edit(Management $management): View
    {
        return view('management.edit', [
            'management' => $management,
            'users'      => User::orderBy('name')->get(),
            'roles'      => Management::ROLES,
        ]);
    }

    public function update(Request $request, Management $management): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'role'          => ['nullable', Rule::in(Management::ROLES)],
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'notes'         => ['nullable', 'string'],
            'linked_to'     => ['nullable', 'exists:users,id'],
        ]);

        $management->update($validated);

        return redirect()->route('management.show', $management)->with('status', 'management-updated');
    }

    public function destroy(Management $management): RedirectResponse
    {
        $management->delete();

        return redirect()->route('management.index')->with('status', 'management-deleted');
    }
}
