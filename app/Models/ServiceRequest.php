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
        "payment_status",
        "completed_at",
        "technician_report",
        "issue_type",
        "issue_reported_at",
        // "price",
        "inspection_fee",
        "repair_cost",
        "client_approved",
        "latitude",
        "longitude",
    ];

    protected $casts = [
        'issue_reported_at' => 'datetime',
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
        return $this->client?->user;
    }

    public function technicianUser()
    {
        return $this->technician?->user;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latest();
    }
}
