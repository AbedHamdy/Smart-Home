<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "service_request_id",
        "technician_id",
    ];
}
