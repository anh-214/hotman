<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'discount',
    ];
    public function types(){
        return $this->hasMany(Type::class,'promotion_id');
    }
}
