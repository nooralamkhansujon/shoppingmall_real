<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['coupon_code','amount_type','amount','expire_date','status'];

    public function getStatusAttribute($value){
        return $value == 1?"Evailable":"Disable";
    }
}
