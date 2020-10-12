<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    public function addProduct(Request $request){

    	if($request->isMethod('post')){
    		$data = $request->all();
    		if(!$request->has('category_id')){
    			return redirect()->back()->with('flash_message_error','Under Category is missing!');
    		}
    		$product = new Product;
    		$product->category_id   = $data['category_id'];
    		$product->product_name  = $data['product_name'];
    		$product->product_code  = $data['product_code'];
    		$product->product_color = $data['product_color'];
    		if($request->has('description')){
    			$product->description = $data['description'];
    		}else{
				$product->description = '';
    		}
    		$product->price = $data['price'];

    		// Upload Image
    		if($request->hasFile('image')){
    			$image_tmp = $request->image;
    			if($image_tmp->isValid()){
    				$extension         = $image_tmp->getClientOriginalExtension();
    				$filename          = rand(111,99999).'.'.$extension;
    				$large_image_path  = public_path('images/backend_images/products/large/'.$filename);
    				$medium_image_path = public_path('images/backend_images/products/medium/'.$filename);
    				$small_image_path  = public_path('images/backend_images/products/small/'.$filename);
                    // Resize Images
    				Image::make($image_tmp)->resize(800,800)->save($large_image_path);
    				Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
    				Image::make($image_tmp)->resize(300,300)->save($small_image_path);

    				// Store image name in products table
    				$product->image = $filename;
    			}
    		}

    		$product->save();
    		/*return redirect()->back()->with('flash_message_success','Product has been added successfully!');*/
            return redirect(route('admin.viewProducts'))->with('flash_message_success','Product has been added successfully!');
    	}

    	$categories = Category::where(['parent_id'=>0])->get();
    	$categories_dropdown = "<option value='' selected disabled>Select</option>";
    	foreach($categories as $cat){
    		$categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
    		$sub_categories       = $cat->categories;
    		foreach ($sub_categories as $sub_cat) {
    			$categories_dropdown .= "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
    		}
    	}
    	return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function viewProducts(){
        $products = Product::with('category')->get();

        return view('admin.products.view_products',compact('products'));
    }

    public function editProduct(Request $request, $productId = null){

        $productDetails = Product::where(['id'=>$productId])->first();

        if($request->isMethod('post')){
            $data = $request->except('_token');
            // Upload Image
    		if($request->hasFile('image')){
    			$image_tmp = $request->image;
    			if($image_tmp->isValid()){
                    $this->deleteProductImage($productDetails->image);
    				$extension         =  $image_tmp->getClientOriginalExtension();
    				$filename          =  rand(111,99999).'.'.$extension;
    				$large_image_path  = 'images/backend_images/products/large/'.$filename;
    				$medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path  = 'images/backend_images/products/small/'.$filename;

    				// Resize Images
    				Image::make($image_tmp)->resize(800,800)->save(public_path($large_image_path));
    				Image::make($image_tmp)->resize(600,600)->save(public_path($medium_image_path));
    				Image::make($image_tmp)->resize(300,300)->save(public_path($small_image_path));

    				// Store image name in products table
    				$data['image'] = $filename;
    			}
            }
            else{
                $data['image']    = $productDetails->image;
            }

            if($request->description !== null){
    			$data['description'] = $data['description'];
    		}else{

				$data['description'] = '';
    		}

            $data['status']  = (isset($data['status']))?$data['status']:"0";
            Product::where(['id'=>$productId])->update($data);
            return redirect(route('admin.viewProducts'))->with('flash_message_success','Product updated Successfully!');
        }

        $categories = Category::where([['parent_id','=',0]])->get();
        $categories_dropdown = "<option value='' selected disabled>Select Category</option>";

    	foreach($categories as $cat){
            $selected             = ($cat->id == $productDetails->category_id)?'selected':"";
    		$categories_dropdown .= "<option  $selected value='{$cat->id}'>{$cat->name}</option>";
    		$sub_categories       = $cat->categories;
    		foreach ($sub_categories as $sub_cat) {
                $selected             = ($sub_cat->id == $productDetails->category_id)?'selected':"";
    			$categories_dropdown .= "<option  $selected value='{$sub_cat->id}'>&nbsp;--&nbsp;{$sub_cat->name}</option>";
    		}
    	}
        return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown'));
    }

    public function deleteProduct(Request $request,$productId=null){
        $product       = Product::find($productId);
        $this->deleteProductImage($product->image);

        if($product->delete()){
            return response()->json('Product has been Deleted !');
        }
        else{
            return response()->json('Product Not Deleted !');
        }


    }

    private function  deleteProductImage($productImage){

        $large_image_path  = public_path('images/backend_images/products/large/'.$productImage);
        $medium_image_path = public_path('images/backend_images/products/medium/'.$productImage);
        $small_image_path  = public_path('images/backend_images/products/small/'.$productImage);

        if(file_exists($large_image_path)){
            unlink($large_image_path);
        }

        if(file_exists($medium_image_path)){
            unlink($medium_image_path);
        }
        if(file_exists($small_image_path)){
            unlink($small_image_path);
        }
    }

    public function addAttributes(Request $request,$productId){
           $productDetails = Product::find($productId);
           if($request->isMethod('post')){
             $data = $request->all();

             foreach($data['sku'] as $key=>$value){
                 //check sku is exist or not
                 $checkSkuExist = ProductsAttribute::where(['sku'=>$value])->get();
                 if(count($checkSkuExist) > 0 ){
                     return redirect()->back()->with('flash_message_error','Product Attributes Sku unit already exists');
                    }
                    if(!empty($value)){
                        //check size for individual  product_id
                        $checkAttribute = ProductsAttribute::where(['size'=>$data['size'][$key],'product_id'=>$productId])->get();
                        if(count($checkAttribute) > 0 ){
                            return redirect()->back()->with('flash_message_error',"{$productDetails->product_name} Attributes size Should be  Unique");
                        }
                    $productAttribute             = new ProductsAttribute();
                    $productAttribute->sku        = $value;
                    $productAttribute->size       = $data['size'][$key];
                    $productAttribute->stock      = $data['stock'][$key];
                    $productAttribute->price      = $data['price'][$key];
                    $productAttribute->product_id = $productId;
                    $productAttribute->save();
                 }
             }
             return redirect()->with('flash_message_success',"Product Attributes has been added");
           }
           return view('admin.products.add_attributes',compact('productDetails'));
    }

    public function deleteAttribute(Request $request,$attributeId =null){
        $productAttribute = ProductsAttribute::find($attributeId);
        if(!$productAttribute){
              return redirect()->back()->with('flash_message_error',"Product Attribute Not Found");
        }
        if($productAttribute->delete()){
            return response()->json('Product Attribute has been Deleted !');
        }
        else{
            return response()->json('Product Attribute not Delete !');
        }
    }

    public function products(Request $request,$url=null){
        $categoryDetails    = Category::with('products')->where('url',$url)->first();
        if($categoryDetails->parent_id == 0){
            $childCategoriesId = $categoryDetails->categories->pluck('id')->toArray();
            $allProducts = Product::whereIn('category_id',$childCategoriesId)->orWhere('category_id',$categoryDetails->id)->get();
        }
        else{
            $allProducts = $categoryDetails->products;
        }
        $categories = $this->categories();//function defined in controller
        return view('products.listing',compact('allProducts','categories','categoryDetails'));
    }
}
