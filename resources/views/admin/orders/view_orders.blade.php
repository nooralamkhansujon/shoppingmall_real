@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
       <a href="{{route('admin.dashboard')}}" title="Go to Dashboard" class="tip-bottom"><i class="icon-home"></i> Dasboard</a>
       <a href="#" class="current">View Orders</a>
    </div>
    <h1>View Orders</h1>
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
            <h5>View Categories</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Order Date</th>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th>Ordered Products</th>
                  <th>Order Amount</th>
                  <th>Order Status</th>
                  <th>Payment Method</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($orders as $order)
                <tr class="gradeX">
                  <td class="center">{{ $order->id }}</td>
                  <td class="center">{{ $order->created_at }}</td>
                  <td class="center">{{ $order->name }}</td>
                  <td class="center">{{ $order->user_email }}</td>
                  <td class="center">
                    @foreach($order->orderProducts as $pro)
                       <a href="{{route('orderDetails',$order->id)}}">
                         {{$pro->product_code}}<br/>
                         Qty:{{$pro->product_qty}}
                        </a> <br/>
                     @endforeach

                  </td>
                  <td class="center">{{$order->grand_total}}</td>
                  <td class="center">{{$order->order_status}}</td>
                  <td class="center">{{$order->payment_method}}</td>
                  <td class="center">
                     <a target="_blank" href="{{route('admin.orderDetails',$order->id)}}" class="btn btn-success btn-mini">view order Details</a>
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
