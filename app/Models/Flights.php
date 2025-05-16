<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flights extends Model
{
    use HasFactory;

    protected $table = 'airlines';

    protected $fillable = [
        'flight_code',
        'home_code',
        'destination_code',
        'airline_id',
        'description',
        'is_active',
    ];

    public function homeAirport()
    {
        return $this->belongsTo(Airports::class, 'home_code');
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airports::class, 'destination_code');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'airline_id');
    }
}
