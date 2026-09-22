<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'user_id',
        'make',
        'model',
        'year',
        'plate_number',
        'vin'
    ];

    // Yeh car kis user ki hai
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Ek car ke many service jobs ho sakte hain
    public function serviceJobs()
    {
        return $this->hasMany(ServiceJob::class);
    }
}