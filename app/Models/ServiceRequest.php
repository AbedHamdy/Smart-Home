<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "client_id",
        "technician_id",
        "category_id",
        "title",
        "description",
        "image",
        "address",
        "status",
        "completed_at",
        "latitude",
        "longitude",
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function clientUser()
    {
        return $this->client->user;
    }
    
    public function technicianUser()
    {
        return $this->technician->user;
    }
}
