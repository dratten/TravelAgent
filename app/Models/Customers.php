<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Companies;
use App\Models\Countries;

class Customers extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'passport_number',
        'nationality',
    ];

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Countries::class, 'nationality');
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class);
    }
}