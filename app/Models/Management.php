<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Management extends Model
{
    use HasFactory;

    protected $table = 'management';

    protected $fillable = [
        'name',
        'email',
        'role',
        'team',
        'nationality',
        'date_of_birth',
        'salary',
        'notes',
        'created_by',
        'linked_to',
        'image',
    ];

    public const ROLES = [
        'General Manager',
        'Team Manager',
        'Director of Basketball Operations',
        'President',
        'Scout',
        'Medical Staff',
        'Administrative Staff',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function linkedUser()
    {
        return $this->belongsTo(User::class, 'linked_to');
    }
}
