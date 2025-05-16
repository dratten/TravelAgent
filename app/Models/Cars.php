<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_code',
        'manufacturer_id',
        'model_id',
        'company_id',
        'seating_no',
        'engine_cc',
        'fuel_type',
        'body_type',
        'description',
        'is_active',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Companies::class, 'manufacturer_id');
    }

    public function vehiclemodel()
    {
        return $this->belongsTo(VehicleModels::class, 'model_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
