<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    public function category()
    {
       return $this->hasOne(BannerCategory::class, 'id', 'id_banner_category');
    }
    
    public function getImageAttribute()
    {
        return $this->attributes['image'] ? asset("image/banners/".$this->attributes['image']) : "";
    }
    public function getMobileImageAttribute()
    {
        return $this->attributes['mobile_image'] ? asset("image/banners/".$this->attributes['mobile_image']) : "";
    }
}
