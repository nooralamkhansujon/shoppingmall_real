<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $fillable = ['parent_id','name','description','url','status'];

     public function Categories(){
         return $this->hasMany(Category::class,'parent_id','id');
     }

     public function parentCategory(){
         return $this->belongsTo(Category::class,'parent_id','id');
     }

     public function products(){
         return $this->hasMany(Product::class,'category_id','id');
     }

     public function getStatusAttribute($value){
         return $value == 1?"Active":"InActive";
     }

}
