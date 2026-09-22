<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'employee_id',
        'phone',
        'is_available'
    ];

    // Ek mechanic ke many service jobs ho sakte hain
    public function serviceJobs()
    {
        return $this->hasMany(ServiceJob::class);
    }
}