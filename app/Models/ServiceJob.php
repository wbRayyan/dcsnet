<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceJob extends Model
{
    protected $fillable = [
        'car_id',
        'mechanic_id',
        'description',
        'status',
        'estimated_cost',
        'final_cost',
        'completed_at'
    ];

    // Yeh job kis car ki hai
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Yeh job kis mechanic ki hai
    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }
}