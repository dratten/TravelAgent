<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customers;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookings extends Model
{
    protected $fillable = [
        'customer_id',
        'booking_date',
        'total_cost',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }

    public function details()
    {
        return $this->hasMany(BookingDetails::class);
    }
}