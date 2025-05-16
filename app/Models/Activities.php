<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_code',
        'title',
        'city',
        'company_id',
        'country_id',
        'period',
        'description',
        'is_active',
    ];

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
}
