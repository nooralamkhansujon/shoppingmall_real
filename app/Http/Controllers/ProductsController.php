<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Cart;
use App\Coupon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

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
            $product->price         = $data['price'];
            $product->care          = $data['care'];
            $product->status        = (isset($data['status']))?$data['status']:"0";
    		if($request->has('description')){
    			$product->description = $data['description'];
    		}else{
				$product->description = '';
    		}


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

            if($request->description !== null)
    			$data['description'] = $data['description'];
    		else
				$data['description'] = '';

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
        if($product == null)
            return redirect()->route('admin.viewProducts')->with('flash_message_error',"Product Not Found");

        $this->deleteProductImage($product->image);
        if($product->delete())
            return response()->json('Product has been Deleted !');
        else
            return response()->json('Product Not Deleted !');

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

    public function addAttributes(Request $request,$productId=null){
           $productDetails = Product::find($productId);
           if($request->isMethod('post')){
             $data = $request->all();

             foreach($data['sku'] as $key=>$value){

                if(!empty($value)){
                    //check sku is exist or not
                    $checkSkuExist = ProductsAttribute::where(['sku'=>$value])->get();
                    if(count($checkSkuExist) > 0 ){
                        return redirect()->back()->with('flash_message_error','Product Attributes Sku unit already exists');
                    }

                    //check size for individual  product_id
                    $checkSizeAttribute = ProductsAttribute::where(['size'=>$data['size'][$key],'product_id'=>$productId])->get();
                    if(count($checkSizeAttribute) > 0 ){
                        return redirect()->back()->with('flash_message_error',"{$productDetails->product_name} Attributes {$data['size'][$key]} size Should be  Unique");
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
             return redirect()->back()->with('flash_message_success',"Product Attributes has been added");
           }
           return view('admin.products.add_attributes',compact('productDetails'));
    }

    public function addProductAltImage(Request $request,$productId=null){
        $productDetails = Product::find($productId);

        if($productDetails == null)
            return redirect()->route('admin.viewProducts')->with('flash_message_error',"Product Not Found");

        if($request->isMethod('post')){
            $data  = $request->all();
            if($request->hasFile('images') ){
                foreach($data['images'] as $imageTmp){
                    if($imageTmp->isValid()){
                        $productsImage     =  new ProductsImage();
                        $extension         =  $imageTmp->getClientOriginalExtension();
                        $filename          = "Alt".rand(111,99999).'.'.$extension;
                        $large_image_path  = 'images/backend_images/products/large/'.$filename;
                        $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                        $small_image_path  = 'images/backend_images/products/small/'.$filename;

                        // Resize Images
                        Image::make($imageTmp)->resize(800,800)->save(public_path($large_image_path));
                        Image::make($imageTmp)->resize(600,600)->save(public_path($medium_image_path));
                        Image::make($imageTmp)->resize(300,300)->save(public_path($small_image_path));

                        $productsImage->image      = $filename;
                        $productsImage->product_id = $productId;
                        $productsImage->save();
                    }
                }
                return redirect()->back()->with('flash_message_success','Product Alt Images Added Successfully');
            }
            else
               return redirect()->back()->with('flash_message_error','Request Data Not Contain any Files Or images');
        }
        return view('admin.products.add_images',compact('productDetails'));
    }

    public function deleteAltImage(Request $request,$altImageId){
        $productAltImage = ProductsImage::find($altImageId);

        if(!$productAltImage){
            if($request->ajax())
                return response('Product Alt Image Not Found',500);
            else
                return redirect()->route('admin.viewProducts')->with('flash_message_error',"Product Alt Image Not Found");
        }
        $this->deleteProductImage($productAltImage->image);
        if($productAltImage->delete())
            return response()->json('Product Alt Images has been Deleted !');
        else
            return response()->json('Product Alt Images not Delete!');
    }

    public function deleteAttribute(Request $request,$attributeId =null){
        $productAttribute = ProductsAttribute::find($attributeId);
        if(!$productAttribute)
            return redirect()->back()->with('flash_message_error',"Product Attribute Not Found");

        if($productAttribute->delete())
            return response()->json('Product Attribute has been Deleted !');
        else
            return response()->json('Product Attribute not Delete !');
    }

    public function products($url=null){
        $categoryDetails    = Category::with('products')->where(['url'=>$url,'status'=>1])->first();
        if(!$categoryDetails)
            return redirect()->route('front.404');

        //if product is parent then
        if($categoryDetails->parent_id == 0){
            ///fetch all categoris id whose parent_id is this category
            $childCategoriesId = $categoryDetails->categories->pluck('id')->toArray();

            //fetch all products whose category id in childCategoriesId array and categoryDetails id
            $allProducts = Product::whereIn('category_id',$childCategoriesId)
                          ->orWhere('category_id',$categoryDetails->id)->where('status',1)->get();
        }
        //so  product is child then
        else
            $allProducts = $categoryDetails->products()->where('status',1)->get();

        $categories = $this->categories();//function defined in controller
        return view('products.listing',compact('allProducts','categories','categoryDetails'));
    }

    //product details
    public function product($productId=null){
        $productDetails  = Product::with('attributes','altImages')->where([['status','=',1],['id','=',$productId]])->first();

        if(!$productDetails)
            return redirect()->route('front.404');

        $totalStock = ProductsAttribute::where('product_id',$productId)->sum('stock');

        //get product Category
        $categoryDetails = Category::where('id',$productDetails->category_id)->first();
        //if product is parent then
        if($categoryDetails->parent_id == 0){
            ///fetch all categoris id whose parent_id is this category
            $childCategoriesId = $categoryDetails->categories->pluck('id')->toArray();

            //fetch all products whose category id in childCategoriesId array and categoryDetails id
            $relatedProducts = Product::whereIn('category_id',$childCategoriesId)
                              ->orWhere('category_id',$categoryDetails->id)
                              ->where([['id','<>',$productDetails->id],['status','=',1]])->get();
        }
        //so  product is child then
        else{
            $relatedProducts = $categoryDetails->products()
                               ->where([['id','<>',$productDetails->id],['status','=',1]])->get();
        }
        $categories = $this->categories();//function defined in controller
        return view('products.details',compact('productDetails','categories','totalStock','relatedProducts'));

    }

    public function updateAttribute(Request $request,$attributeId=null){
        $attribute = ProductsAttribute::find($attributeId);
        if($attribute == null){
            return redirect()->route('front.404');
        }
        $attribute->price  = $request->price;
        $attribute->stock = $request->stock;
        $attribute->save();
        return redirect()->back()->with('flash_message_success',"{$attribute->sku} Attribute stock and price updated Successfully");

    }


    ///ajax request
    public function getProductPrice(Request $request,$productId=null,$attributeId=null){
        if($productId == null or $attributeId == null){
            return redirect()->route('front.404');
        }
        $productAttribute  = ProductsAttribute::where(['product_id'=>$productId,'id'=>$attributeId])->first();
        if($productAttribute == null){
             return response("false",500);
        }
        return response()->json($productAttribute);
    }

    public function addToCart(Request $request,$productId=null){
        Session::forget('couponAmount');
        Session::forget('couponCode');

        if($request->isMethod('post')){

            if(!$request->has('attribute'))
                return redirect()->back()->with('flash_message_error','Please Select Size');

            $productAttribute = ProductsAttribute::where('id',$request->attribute)->first();

            $session_id = session()->get('session_id');
            if(empty($session_id))
            {
                $session_id = Str::random(40);
                session()->put('session_id',$session_id);
            }

            // check product and size already exist or not
            $checkProduct   = Cart::where([['product_id','=',$productId],['size','=',$productAttribute->size],['session_id',$session_id]])->count();
            if($checkProduct > 0)
                    return redirect()->back()->with('flash_message_error',"Product with {$productAttribute->size} size already Exist in Cart");


            $product = Product::find($productId);
            if(!$productAttribute || !$product)
                return redirect()->route('front.404');



            if(!$request->has('user_email') && empty('user_email'))
                 $user_email = "";
            else
               $user_email   = $request->user_email;

            $data  = array(
                'product_id'    => $product->id,
                'product_name'  => $product->product_name,
                'product_code'  => $productAttribute->sku,
                'product_color' => $product->product_color,
                'size'          => $productAttribute->size,
                'price'         => $productAttribute->price,
                'quantity'      => $request->quantity,
                'user_email'    => $user_email,
                'session_id'    => $session_id
            );
            Cart::create($data);
            return redirect()->route('front.cart')->with('flash_message_success','Product Successfully Added To Cart!');

        }

    }

    public function cart(){
      $session_id = session()->get('session_id');
      $cartProducts  = Cart::with('product')->where('session_id',$session_id)->get();
      return view('products.cart',compact('cartProducts'));
    }

    public function deleteCartProduct(Request $request,$cartId){
        Session::forget('couponAmount');
        Session::forget('couponCode');

        $cart   = Cart::find($cartId);
        if($cart == null)
            redirect()->route('front.404');
        if($cart->delete())
           return redirect()->back()->with('flash_message_success',"Product has been deleted Successfully");
    }

    public function updateCartQuantity(Request $request,$cartId =null,$quantity=null){
        Session::forget('couponAmount');
        Session::forget('couponCode');

        //get Cart Item
        $quantity = (int) $quantity;
        if($quantity == 0)
              return redirect()->route('front.404');

        $cartItem   = Cart::find($cartId);
        if($cartItem == null)
             redirect()->route('front.404');


        //check quantity
        $checkquantity = $cartItem->quantity + $quantity;//quantity could be 1 or -1

        if($checkquantity > 0){

            /// check size of this product stock is available or not
            $totalStock = ProductsAttribute::where([['product_id','=',$cartItem->product_id],['size','=',$cartItem->size]])->sum('stock');

            //if quantity is greater then total stock then redirect with error
            if($checkquantity > $totalStock){
               return redirect()->back()->with('flash_message_error',"Required Product Quantity Not Available for This Size !");
            }

            //if every thing is ok then update quantity
            $cartItem->update(['quantity'=>$checkquantity]);
            return redirect()->back()->with('flash_message_success',"Product Quantity Updated Successfully !");
        }
        else{
            $cartItem->delete();
            return redirect()->back()->with('flash_message_error',"Cart Item Deleted Successfully!");
        }

    }

    public function applyCoupon(Request $request){

        //if coupon already applied then remove fist
        Session::forget('couponAmount');
        Session::forget('couponCode');

        $coupon = Coupon::where('coupon_code',$request->coupon_code)->first();

        if($coupon == null)
           return redirect()->route('front.cart')->with('flash_message_error','Coupon Code Not Match');

        //if coupon is inactive
        if($coupon->status == 'Disable')
            return redirect()->back()->with('flash_message_error','Your Coupon is Not Active');

        //check if coupon is expired or not
        if($coupon->expire_date < date('Y-m-d'))
            return redirect()->back()->with('flash_message_error','Your Coupon is expired');

        if($coupon->amount_type == 'fixed')
            $couponAmount = $coupon->amount;
        else{
            $session_id    = session()->get('session_id');
            $cartItem      = Cart::where('session_id',$session_id)->get();
            $total_amount  = 0;
            foreach($cartItem as $cart){
                $total_amount += $cart->price * $cart->quantity;
            }
            $couponAmount = $total_amount * ($coupon->amount / 100);
        }
        //add Coupon Code & amount in Session
        Session::put('couponAmount',$couponAmount);
        Session::put('couponCode',$coupon->coupon_code);
        return redirect()->back()->with('flash_message_success',"Coupon Code Successfully applied.are availing discount!");


    }
}
