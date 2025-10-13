<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        "category_id",
        "experience_years",
        "availability_status",
        "rating",
        "latitude",
        "longitude",
        "cv_file",
        "verified",
        "last_activity",
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assignedRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'technician_id');
    }
}
