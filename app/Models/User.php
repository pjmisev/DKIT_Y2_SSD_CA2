<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'position',
        'salary',
        'status',
        'auth_provider',
        'auth_provider_id',
        'team_id',
    ];

    /**
     * Get the team this user belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the profile associated with this user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Check if the user has a profile of the given type.
     */
    public function hasProfileType(string $type): bool
    {
        return $this->profile?->profileable_type === $type;
    }

    /**
     * Check if the user is a player.
     */
    public function isPlayer(): bool
    {
        return $this->hasProfileType(PlayerInfo::class);
    }

    /**
     * Check if the user is a coach.
     */
    public function isCoach(): bool
    {
        return $this->hasProfileType(CoachInfo::class);
    }

    /**
     * Check if the user is management.
     */
    public function isManagement(): bool
    {
        return $this->hasProfileType(ManagementInfo::class);
    }

    /**
     * Get the player info through the profile.
     */
    public function playerInfo()
    {
        return $this->isPlayer() ? $this->profile->profileable : null;
    }

    /**
     * Get the coach info through the profile.
     */
    public function coachInfo()
    {
        return $this->isCoach() ? $this->profile->profileable : null;
    }

    /**
     * Get the management info through the profile.
     */
    public function managementInfo()
    {
        return $this->isManagement() ? $this->profile->profileable : null;
    }
}
