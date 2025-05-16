<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Hotels;

class Companies extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * Define relationship: A company may have many hotels (if it's a hotel type).
     */
    public function hotels()
    {
        return $this->hasMany(Hotels::class, 'hotel_main_id');
    }

    public function flights()
    {
        return $this->hasMany(Flights::class, 'airline_id');
    }
}

