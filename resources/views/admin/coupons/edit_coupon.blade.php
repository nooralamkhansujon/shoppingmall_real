@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="{{route('admin.dashboard')}}" title="Go to Dasbhoard" class="tip-bottom"><i class="icon-home"></i> Dasbhoard</a>
        <a href="{{route('admin.viewCoupons')}}" >Coupons</a>
        <a href="#" disabled class="current">Edit Coupon</a> </div>
        <h1>Coupons</h1>
    </div>
   <div class="container-fluid"><hr>
     <div class="row-fluid">
       <div class="span12">
         <div class="widget-box">
           <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Coupon</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ route('admin.editCoupon',$coupon->id) }}" name="add_coupon" id="add_coupon" novalidate="novalidate">
                @csrf
             <div class="control-group">
               <label class="control-label">Coupon Code</label>
               <div class="controls">
                 <input type="text" minlength="5" maxlength="15" name="coupon_code" value={{$coupon->coupon_code}} id="coupon_code">
               </div>
             </div>
             <div class="control-group">
               <label class="control-label">Amount Type</label>
               <div class="controls">
                 <select name="amount_type" style="width:200px;" id="amount_type">
                     <option {{$coupon->amount_type == 'percentage'?'selected':""}} value="percentage">Percentage</option>
                     <option {{$coupon->amount_type == 'fixed'?'selected':""}} value="fixed">Fixed</option>
                 </select>
               </div>
             </div>
             <div class="control-group">
               <label class="control-label">Amount</label>
               <div class="controls">
               <input type="number" name="amount" value="{{$coupon->amount}}" id="amount">
               </div>
             </div>
             <div class="control-group">
               <label class="control-label">Expire Date</label>
               <div class="controls">
               <input type="text" name="expire_date" autocomplete="off"  value="{{$coupon->expire_date}}" id="expire_date">
               </div>
             </div>
             <div class="control-group">
               <label class="control-label">Status</label>
               <div class="controls">
                 <input type="checkbox" name="status" id="status" {{$coupon->status == "Evailable" ?'checked':""}} value="1" >
               </div>
             </div>

             <div class="form-actions">
               <input type="submit" value="Edit Coupon" class="btn btn-success">
             </div>
           </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
