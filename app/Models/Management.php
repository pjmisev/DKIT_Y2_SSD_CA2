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
        'team',
        'nationality',
        'date_of_birth',
        'salary',
        'notes',
        'created_by',
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
}
