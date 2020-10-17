@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
         <a href="{{route('admin.dashboard')}}" title="Go to Dashboard" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
         <a href="#" disabled class="current">View Coupons</a> </div>
    <h1>Products</h1>
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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Coupons</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Coupon ID</th>
                  <th>Coupon Code</th>
                  <th>Amount Type</th>
                  <th>Expire Date</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($coupons as $coupon)
                    <tr class="gradeX">
                        <td>{{ $coupon->id }}</td>
                        <td>{{ $coupon->coupon_code ?? "" }}</td>
                        <td>{{ $coupon->amount_type }}</td>
                        <td>{{ $coupon->expire_date }}</td>
                        <td>{{ ($coupon->amount_type == 'percentage')?$coupon->amount."%":"Tk.".$coupon->amount }}</td>
                        <td>{{ $coupon->status}}</td>
                        <td class="center">
                            <a  href="{{route('admin.editCoupon',$coupon->id)}}" class="btn btn-primary btn-mini ">Edit</a>
                            <a rel="{{$coupon->id}}" rel1="delete-coupon" href="javascript:void(0);" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                        </td>
                    </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
