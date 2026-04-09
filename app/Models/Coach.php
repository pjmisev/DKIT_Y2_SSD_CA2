<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'team',
        'role',
        'experience_years',
        'created_by',
    ];

    public const ROLES = [
        'Head Coach',
        'Assistant Coach',
        'Strength & Conditioning Coach',
        'Skills Coach',
        'Team Manager',
    ];

     public function casts(): array
    {
        return [
            'experience_years' => 'integer',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
