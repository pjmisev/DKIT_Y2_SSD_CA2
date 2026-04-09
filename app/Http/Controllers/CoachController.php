<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

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
            'roles' => Coach::ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'team' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', Rule::in(Coach::ROLES)],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
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
            'roles' => Coach::ROLES,
        ]);
    }

    public function update(Request $request, Coach $coach): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'team' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', Rule::in(Coach::ROLES)],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
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