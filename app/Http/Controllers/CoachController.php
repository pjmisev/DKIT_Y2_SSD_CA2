<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CoachController extends Controller
{
    public function index(): View
    {
        $coaches = Coach::orderBy('name')->get();

        return view('coaches.index', compact('coaches'));
    }

    public function create(): View
    {
        return view('coaches.create', [
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'notes'         => ['nullable', 'string'],
            'linked_to'     => ['nullable', 'exists:users,id'],
        ]);

        $validated['created_by'] = Auth::id();

        Coach::create($validated);

        return redirect()->route('coaches.index')->with('status', 'coach-created');
    }

    public function show(Coach $coach): View
    {
        return view('coaches.show', compact('coach'));
    }

    public function edit(Coach $coach): View
    {
        return view('coaches.edit', [
            'coach' => $coach,
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Coach $coach): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'notes'         => ['nullable', 'string'],
            'linked_to'     => ['nullable', 'exists:users,id'],
        ]);

        $coach->update($validated);

        return redirect()->route('coaches.show', $coach)->with('status', 'coach-updated');
    }

    public function destroy(Coach $coach): RedirectResponse
    {
        $coach->delete();

        return redirect()->route('coaches.index')->with('status', 'coach-deleted');
    }
}
