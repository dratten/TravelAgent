<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Hotels;

class Countries extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iso_code',
        'continent',
    ];

    /**
     * Define relationship: A country may have many hotels.
     */
    public function hotels()
    {
        return $this->hasMany(Hotels::class);
    }
}
