<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','product_name','product_code','product_color','description','price','image','status'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function Attributes(){
        return $this->hasMany(ProductsAttribute::class,'product_id','id');
    }




}
