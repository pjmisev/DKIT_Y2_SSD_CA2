<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = [
        'name',
        'theme_color',
    ];

    /**
     * Get all users belonging to this team.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all profiles belonging to this team.
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
