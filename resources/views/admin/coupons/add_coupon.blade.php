@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
         <a href="{{route('admin.dashboard')}}" title="Go to Desboard" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
         <a href="{{route('admin.viewCoupons')}}" >View Coupons</a>
         <a disabled class="current">Add Coupons</a>
         </div>
    <h1>Coupons</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_error') !!}</strong>
        </div>
    @endif
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Coupon</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ route('admin.addCoupon') }}" name="add_coupon" id="add_coupon" novalidate="novalidate">
                 @csrf
              <div class="control-group">
                <label class="control-label">Coupon Code</label>
                <div class="controls">
                  <input type="text" name="coupon_code" minlength="5" maxlength="15" id="coupon_code">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Amount Type</label>
                <div class="controls">
                  <select name="amount_type" style="width:200px;" id="amount_type">
                      <option value="percentage">Percentage</option>
                      <option value="fixed">Fixed</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Amount</label>
                <div class="controls">
                  <input type="number" min="0" name="amount" id="amount">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Expire Date</label>
                <div class="controls">
                  <input type="text" autocomplete="off" name="expire_date" id="expire_date">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Status</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1" >
                </div>
              </div>

              <div class="form-actions">
                <input type="submit" value="Add Coupon" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
