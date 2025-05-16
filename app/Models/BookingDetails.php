<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Bookings;

class BookingDetails extends Model
{
    protected $fillable = [
        'booking_id',
        'bookable_type',
        'bookable_id',
        'start_date',
        'end_date',
        'number_plate',
        'number_of_rooms',
        'number_of_people',
        'reservation_number',
        'number_of_seats',
        'is_return',
        'return_flight_detail_id',
        'flight_number',
        'unit_cost',
        'total_cost',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Bookings::class);
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function returnFlightDetail(): BelongsTo
    {
        return $this->belongsTo(self::class, 'return_flight_detail_id');
    }
}