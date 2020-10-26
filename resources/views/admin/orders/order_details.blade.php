@extends('layouts.adminLayout.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Orders</a> </div>
    <h1>Order #{{ $orderDetails->id }}</h1>
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif
    @if(Session::has('flash_message_error'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_error') !!}</strong>
        </div>
   @endif
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title">
            <h5>Order Details</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td class="taskDesc">Order Date</td>
                  <td class="taskStatus">{{ $orderDetails->created_at }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Order Status</td>
                  <td class="taskStatus">{{ $orderDetails->order_status }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Order Total</td>
                  <td class="taskStatus">Tk. {{ $orderDetails->grand_total }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Shipping Charges</td>
                  <td class="taskStatus">Tk. {{ $orderDetails->shipping_charges }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Coupon Code</td>
                  <td class="taskStatus">{{ $orderDetails->coupon_code?$orderDetails->coupon_code: "Not Available" }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Coupon Amount</td>
                  <td class="taskStatus">Tk.{{$orderDetails->coupon_amount  }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Payment Method</td>
                  <td class="taskStatus">{{ $orderDetails->payment_method }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title">
                <h5>Billing Address</h5>
              </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content">
                {{ $userDetails->name }} <br>
                {{ $userDetails->address }} <br>
                {{ $userDetails->city }} <br>
                {{ $userDetails->state }} <br>
                {{ $userDetails->country->name }} <br>
                {{ $userDetails->pincode }} <br>
                {{ $userDetails->mobile }} <br>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title">
            <h5>Customer Details</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td class="taskDesc">Customer Name</td>
                  <td class="taskStatus">{{ $orderDetails->name }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Customer Email</td>
                  <td class="taskStatus">{{ $orderDetails->user_email }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title">
                <h5>Update Order Status</h5>
              </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content">
                <form action="{{ url('admin/update-order-status',$orderDetails->id) }}" method="post">
                    @csrf
                  <table width="100%">
                    <tr>
                      <td>
                        <select name="order_status" id="order_status" class="control-label" required="">
                            <option value="New" {{($orderDetails->order_status == "New")? 'selected':""}} >New</option>
                            <option value="Pending" {{($orderDetails->order_status == "Pending")? 'selected':""}} >Pending</option>
                            <option value="Cancelled" {{($orderDetails->order_status == "Cancelled")? 'selected':""}} >Cancelled</option>
                            <option value="In Process" {{($orderDetails->order_status == "In Process")? 'selected':""}} >In Process</option>
                            <option value="Shipped" {{($orderDetails->order_status == "Shipped")? 'selected':""}} >Shipped</option>
                            <option value="Delivered" {{($orderDetails->order_status == "Delivered")? 'selected':""}} >Delivered</option>
                            <option value="Paid" {{($orderDetails->order_status == "Paid")? 'selected':""}} >Paid</option>
                        </select>
                      </td>
                      <td>
                        <input type="submit" value="Update Status">
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
          </div>
        </div>
       	<div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title">
                <h5>Shipping Address</h5>
              </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content">
                {{ $orderDetails->name }} <br>
                {{ $orderDetails->address }} <br>
                {{ $orderDetails->city }} <br>
                {{ $orderDetails->state }} <br>
                {{ $orderDetails->country->name }} <br>
                {{ $orderDetails->pincode }} <br>
                {{ $orderDetails->mobile }} <br></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
              <tr>
                  <th>Product Code</th>
                  <th>Product Name</th>
                  <th>Product Size</th>
                  <th>Product Color</th>
                  <th>Product Price</th>
                  <th>Product Qty</th>
              </tr>
          </thead>
          <tbody>
            @foreach($orderDetails->orderProducts as $pro)
              <tr>
                  <td>{{ $pro->product_code }}</td>
                  <td>{{ $pro->product_name }}</td>
                  <td>{{ $pro->product_size }}</td>
                  <td>{{ $pro->product_color }}</td>
                  <td>{{ $pro->product_price }}</td>
                  <td>{{ $pro->product_qty }}</td>
              </tr>
              @endforeach
          </tbody>
      </table>
    </div>
  </div>
</div>
<!--main-container-part-->

@endsection
