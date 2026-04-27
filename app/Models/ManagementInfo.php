<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ManagementInfo extends Model
{
    protected $table = 'management_info';

    protected $fillable = ['role'];

    public const ROLES = [
        'General Manager',
        'Team Manager',
        'Director of Basketball Operations',
        'President',
        'Scout',
        'Medical Staff',
        'Administrative Staff',
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
