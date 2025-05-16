<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airports extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iata_code',
        'city',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function departingFlights()
    {
        return $this->hasMany(Flights::class, 'home_code');
    }

    public function arrivingFlights()
    {
        return $this->hasMany(Flights::class, 'destination_code');
    }
}
