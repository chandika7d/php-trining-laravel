<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;
    
    public function getPhotoAttribute()
    {
        return $this->attributes['photo'] ? asset("image/brands/".$this->attributes['photo']) : "";
    }

    public function getSecondaryPhotoAttribute()
    {
        return $this->attributes['secondary_photo'] ? asset("image/brands/".$this->attributes['secondary_photo']) : "";
    }
}
