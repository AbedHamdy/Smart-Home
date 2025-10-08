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
        "verified",
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
