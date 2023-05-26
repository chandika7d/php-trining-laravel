<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocassion extends Model
{
    use HasFactory;

    public function getImageAttribute()
    {
        return $this->attributes['image'] ? asset("image/ocassions/".$this->attributes['image']) : "";
    }
}
