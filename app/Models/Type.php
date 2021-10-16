<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'initial_price',
        'sizes',
        'color',
        'designs',
        'details',
        'material',
        'product_id'
    ];
    public function images(){
        return $this->hasMany(Image::class,'type_id');
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function latest($column = 'created_at')
    {
        return $this->orderBy($column, 'desc');
    } 
    public function promotion(){
        return $this->belongsTo(Promotion::class);
    }
}
