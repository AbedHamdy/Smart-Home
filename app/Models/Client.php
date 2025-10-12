<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        "address",
        "latitude",
        "longitude",
        "last_activity",
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
