<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Intervention\Image\Facades\Image;
class BannersController extends Controller
{
   public function addBanner(Request $request){
        if($request->isMethod('post')){
            $data                = $request->except('_token');
            $data['status']      = $request->has('status')?$request->status:"0";
            // Upload Image
    		if($request->hasFile('image') && $request->image->isValid()){
                $image_tmp         = $request->image;
                $extension         = $image_tmp->getClientOriginalExtension();
                $filename          = rand(111,99999).'.'.$extension;
                $image_path  = public_path('images/frontend_images/banners/'.$filename);
                // Resize Images
                Image::make($image_tmp)->resize(1140,340)->save($image_path);
                // Store image name in products table
                $data['image'] = $filename;

            }
            else{
                return redirect()->back()->with('flash_message_error','Banner is image required or should be valid');
            }
            Banner::create($data);
           return redirect()->route('admin.viewBanners')->with('flash_message_success',"Banner Added Successfully");
        }
        return view('admin.banners.add_banner');
    }

    public function viewBanners(){
        $banners = Banner::all();
        return view('admin.banners.view_banners',compact('banners'));
    }

    public function editBanner(Request $request,$bannerId){
        $banner = Banner::find($bannerId);
        if($banner == null)
            return redirect()->back()->with('flash_message_error',"Banner Not Found");

        if($request->isMethod('post')){
            $data                = $request->except('_token');
            $data['status']      = $request->has('status')?$request->status:"0";
            // Upload Image
    		if($request->hasFile('image') && $request->image->isValid()){
                $this->deleteBannerImage($banner->image);
    			$image_tmp = $request->image;
                $extension         = $image_tmp->getClientOriginalExtension();
                $filename          = rand(111,99999).'.'.$extension;
                $image_path  = public_path('images/frontend_images/banners/'.$filename);
                // Resize Images
                Image::make($image_tmp)->resize(1140,340)->save($image_path);
                // Store image name in products table
                $data['image'] = $filename;
            }
            else{
               $data['image'] = $banner->image;
            }
            $banner->update($data);
            return redirect()->route('admin.viewBanners')->with('flash_message_success',"Banner Updated Successfully");
        }
        return view('admin.banners.edit_banner',compact('banner'));
    }

    private function  deleteBannerImage($bannerImage){
        $image_path  = public_path('images/frontend_images/banners/'.$bannerImage);

        if(file_exists($image_path)){
            unlink($image_path);
        }
    }


    public function deleteBanner(Request $request,$bannerId=null){
        $banner       = Banner::find($bannerId);
        if($banner == null)
            return response()->json('Banner Not Found!',500);
        if($banner->delete())
            return response()->json('Banner has been Deleted !');
        else
            return response()->json('Banner Not Deleted !');


    }
}
