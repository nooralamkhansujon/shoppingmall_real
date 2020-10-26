@extends('layouts.frontLayout.front_design')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Thanks</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <table id="orderProductsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>User Email</th>
                    <th>Ordered Products</th>
                    <th>Payment Method</th>
                    <th>Grand Total</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                       <th>{{$order->user_email}}</th>
                        <td>
                            @foreach($order->orderProducts as $pro)
                              <a href="{{route('orderDetails',$order->id)}}">
                                {{$pro->product_code}}</a> <br/>
                            @endforeach
                        </td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->grand_total }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>View Details</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
