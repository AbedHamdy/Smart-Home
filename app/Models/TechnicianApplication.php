<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicianApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "phone",
        "category_id",
        "skills",
        "experience",
        "cv_file",
        "status",
        "notes",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
