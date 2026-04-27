<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'profileable_type',
        'profileable_id',
        'team_id',
        'nationality',
        'date_of_birth',
        'notes',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profileable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the team this profile belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the profile's role-specific label (e.g. "Point Guard", "Head Coach", "General Manager").
     */
    public function getRoleLabelAttribute(): ?string
    {
        return $this->profileable?->role;
    }

    /**
     * Get the display name for the profile type.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->profileable_type) {
            PlayerInfo::class => 'Player',
            CoachInfo::class  => 'Coach',
            ManagementInfo::class => 'Management',
            default           => class_basename($this->profileable_type),
        };
    }
}
