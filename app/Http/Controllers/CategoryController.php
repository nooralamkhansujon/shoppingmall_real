<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		//echo "<pre>"; print_r($data); die;
    		$category = new Category;
    		$category->name        = $data['category_name'];
            $category->parent_id   = $data['parent_id'];
    		$category->description = $data['description'];
    		$category->url         = $data['url'];
    		$category->save();
    		return redirect(route('admin.viewCategories'))->with('flash_message_success','Category added Successfully!');
    	}

        $levels = Category::where(['parent_id'=>0])->get();

    	return view('admin.categories.add_category')->with(compact('levels'));
    }

    public function editCategory(Request $request, $categoryId = null){

        if($request->isMethod('post')){
            $data = $request->all();

            Category::where(['id'=>$categoryId])->update(['name'=>$data['category_name'],'description'=>$data['description'],'url'=>$data['url'],'parent_id'=>$data['parent_id']]);
            return redirect('/admin/view-categories')->with('flash_message_success','Category updated Successfully!');
        }
        $categoryDetails = Category::where(['id'=>$categoryId])->first();
        $levels = Category::where([['parent_id','=',0],['id','<>',$categoryDetails->id]])->get();
        return view('admin.categories.edit_category')->with(compact('categoryDetails','levels'));
    }

    public function deleteCategory(Request $request, $categoryId = null){
        $category       = Category::find($categoryId);

        if($category->delete()){
            return response()->json('Category has been Deleted !');
        }
        else{
            return response()->json('Category Not Deleted !');
        }
    }

    public function viewCategories(){

    	$categories = Category::with('parentCategory')->get();
    	return view('admin.categories.view_categories',compact('categories'));
    }
}
