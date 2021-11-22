<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homesort extends Model
{
    use HasFactory;
    public function getContentAttribute($value){
        return $this->attributes['password'] = str_replace('<replace_url>',url(''),$value);
    }
}
