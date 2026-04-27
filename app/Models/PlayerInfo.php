<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PlayerInfo extends Model
{
    protected $table = 'player_info';

    protected $fillable = [
        'jersey_number',
        'position',
        'dominant_hand',
        'height_cm',
        'weight_kg',
        'health_status',
    ];

    public const HEALTH_STATUSES = ['fit', 'injured', 'recovering', 'suspended'];
    public const POSITIONS = ['Point Guard', 'Shooting Guard', 'Small Forward', 'Power Forward', 'Center'];

    public function profile(): MorphOne
    {
        return $this->morphOne(Profile::class, 'profileable');
    }

    /**
     * Get the user through the profile.
     */
    public function user()
    {
        return $this->profile?->user();
    }
}
