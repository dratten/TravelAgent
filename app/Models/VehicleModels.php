<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModels extends Model
{
    use HasFactory;

    protected $table = 'vehicle_models'; // Explicitly declare the table name

    protected $fillable = [
        'name',
        'manufacturer_id',
    ];

    /**
     * Relationship: A vehicle model belongs to a manufacturer (company).
     */
    public function company()
    {
        return $this->belongsTo(Companies::class, 'manufacturer_id');
    }
}
