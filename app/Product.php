<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','product_name','product_code','product_color','description','price','image','status','care'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function attributes(){
        return $this->hasMany(ProductsAttribute::class,'product_id','id');
    }

    public function altImages(){
        return $this->hasMany(ProductsImage::class,'product_id','id');
    }

    public function getStatusAttribute($value){
        return $value == 1?"Active":"InActive";
    }




}
