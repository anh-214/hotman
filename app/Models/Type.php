<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    public function images(){
        return $this->hasMany(Image::class,'type_id');
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}