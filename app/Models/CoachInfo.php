<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class CoachInfo extends Model
{
    protected $table = 'coach_info';

    protected $fillable = ['role'];

    public const ROLES = [
        'Head Coach',
        'Assistant Coach',
        'Strength & Conditioning Coach',
        'Skills Coach',
        'Video Analyst',
    ];

    public function profile(): MorphOne
    {
        return $this->morphOne(Profile::class, 'profileable');
    }

    public function user()
    {
        return $this->profile?->user();
    }
}
