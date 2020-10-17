<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function addCoupon(Request $request){
        if($request->isMethod('post')){
            $data                = $request->except('_token');
            $data['status']      = $request->has('status')?$request->status:"0";
            Coupon::create($data);
           return redirect()->route('admin.viewCoupons')->with('flash_message_success',"Coupon Added Successfully");
        }
        return view('admin.coupons.add_coupon');
    }

    public function viewCoupons(){
        $coupons = Coupon::all();
        return view('admin.coupons.view_coupons',compact('coupons'));
    }

    public function editCoupon(Request $request,$couponId){
        $coupon = Coupon::find($couponId);
        if($coupon == null)
            return redirect()->back()->with('flash_message_error',"Coupon Not Found");

        if($request->isMethod('post')){
            $data                = $request->except('_token');
            $data['status']      = $request->has('status')?$request->status:"0";
            $coupon->update($data);
            return redirect()->route('admin.viewCoupons')->with('flash_message_success',"Coupon Updated Successfully");
        }
        return view('admin.coupons.edit_coupon',compact('coupon'));
    }

    public function deleteCoupon(Request $request,$couponId=null){
        $coupon       = Coupon::find($couponId);
        if($coupon == null)
            return response()->json('Coupon Not Found!',500);
        if($coupon->delete())
            return response()->json('Coupon has been Deleted !');
        else
            return response()->json('Coupon Not Deleted !');


    }
}
