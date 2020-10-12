<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
class IndexController extends Controller
{
    public function index(Request $request){
        $allProducts = Product::inRandomOrder()->get();
        //
        $categories = $this->categories();
        return view('index',compact('allProducts','categories'));
    }

    public function show404Page(Request $request){
        return view('layouts.frontLayout.front_404');
    }
}
