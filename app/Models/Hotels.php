<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Companies;
use App\Models\Countries;

class Hotels extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_code',
        'name',
        'city',
        'hotel_main_id',
        'country_id',
        'description',
        'policies',
    ];

    /**
     * Get the main company that owns the hotel.
     */
    public function company()
    {
        return $this->belongsTo(Companies::class, 'hotel_main_id');
    }

    /**
     * Get the country where the hotel is located.
     */
    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
}
