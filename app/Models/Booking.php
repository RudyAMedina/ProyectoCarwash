<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'user_id',
    'service_id',
    'vehicle_model_id',
    'license_plate',
    'scheduled_at',
    'status',
    ];
    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
}
