<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        "service_request_id",
        "technician_id",
        "client_id",
        "rating",
        "comment",
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * Get the client who made the rating
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the technician who was rated
     */
    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}
