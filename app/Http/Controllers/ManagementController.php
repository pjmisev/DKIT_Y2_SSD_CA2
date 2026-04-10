<?php

namespace App\Http\Controllers;

use App\Models\Management;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ManagementController extends Controller
{
    public function index(): View
    {
        $members = Management::orderBy('name')->get();

        return view('management.index', compact('members'));
    }

    public function create(): View
    {
        return view('management.create');
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
        return view('management.edit', compact('management'));
    }

    public function update(Request $request, Management $management): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'notes'         => ['nullable', 'string'],
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
