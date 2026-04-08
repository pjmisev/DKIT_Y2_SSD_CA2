<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'jersey_number',
        'age',
        'date_of_birth',
        'position',
        'nationality',
        'dominant_hand',
        'height_cm',
        'weight_kg',
        'health_status',
        'team',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public const HEALTH_STATUSES = ['fit', 'injured', 'recovering', 'suspended'];
    public const POSITIONS = ['Point Guard', 'Shooting Guard', 'Small Forward', 'Power Forward', 'Center'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}