<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'location',
        'latitude',
        'longitude',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the full address for Google Maps link.
     */
    public function getMapUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }

        if ($this->location) {
            return 'https://www.google.com/maps?q=' . urlencode($this->location);
        }

        return null;
    }

    /**
     * Get the embed URL for the Google Map iframe.
     */
    public function getEmbedMapUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps/embed/v1/place?key=" . config('services.google.maps_key') . "&q={$this->latitude},{$this->longitude}&zoom=15";
        }

        if ($this->location) {
            return "https://www.google.com/maps/embed/v1/place?key=" . config('services.google.maps_key') . "&q=" . urlencode($this->location) . "&zoom=15";
        }

        return null;
    }
}
