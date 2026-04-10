<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Management;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CoachController extends Controller
{
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
        $query = Coach::query();

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

        $coaches = $query->orderBy('name')->get();

        return view('coaches.index', compact('coaches'));
    }

    public function create(): View
    {
        return view('coaches.create', [
            'users' => User::whereNotIn('id', $this->takenUserIds())->orderBy('name')->get(),
            'roles' => Coach::ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'role'          => ['nullable', Rule::in(Coach::ROLES)],
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'salary'        => ['nullable', 'integer', 'min:0'],
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
            'users' => User::whereNotIn('id', $this->takenUserIds($coach->linked_to))->orderBy('name')->get(),
            'roles' => Coach::ROLES,
        ]);
    }

    public function update(Request $request, Coach $coach): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255'],
            'role'          => ['nullable', Rule::in(Coach::ROLES)],
            'team'          => ['nullable', 'string', 'max:255'],
            'nationality'   => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'salary'        => ['nullable', 'integer', 'min:0'],
            'notes'         => ['nullable', 'string'],
            'linked_to'     => ['nullable', 'exists:users,id', function ($attr, $value, $fail) use ($coach) {
                if (!$value) return;
                $taken = Player::where('linked_to', $value)->exists()
                      || Coach::where('linked_to', $value)->where('id', '!=', $coach->id)->exists()
                      || Management::where('linked_to', $value)->exists();
                if ($taken) {
                    $fail('This user is already linked to another player, coach, or management member.');
                }
            }],
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
