<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use HoangPhi\VietnamMap\Models\Ward;


class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'payment_type',
        'checkout_status',
        'user_id',
        'ward_id',
        'details_address',
        'is_read',
        'created_at',
    ];
    // public $timestamps = false;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function ward(){
        return $this->belongsTo(Ward::class);
    }
    
    // public function getCreatedAtAttribute($time)
    // {   return $this->attributes['created_at'] = ConvertTimezone::convert_timezone($time);
    // }
    // public function getConfirmedAtAttribute($time)
    // {
    //     return $this->attributes['confirmed_at'] = ConvertTimezone::convert_timezone($time);
    // }
    // public function getStartDeliverAtAttribute($time)
    // {
    //     return $this->attributes['start_deliver_at'] = ConvertTimezone::convert_timezone($time);
    // }
    // public function getDeliveredAtAttribute($time)
    // {
    //     return $this->attributes['delivered_at'] = ConvertTimezone::convert_timezone($time);
    // }
    // public function getDeletedAtAttribute($time)
    // {
    //     return $this->attributes['deleted_at'] = ConvertTimezone::convert_timezone($time);
    // }
}
