@extends('layouts.frontLayout.front_design')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
            <li><a href="{{route('front.index')}}">Home</a></li>
              <li><a href="{{route('user.orders')}}">Orders</a></li>
              <li class="active">{{$orderDetails->id}}</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <table id="orderProductsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Product Size</th>
                    <th>Product Color</th>
                    <th>Product price</th>
                    <th>Product Quantity</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderDetails->orderProducts as $orderPro)
                    <tr>
                        <td>{{$orderPro->product_code}}</td>
                        <td>
                           {{$orderPro->product_name}}
                        </td>
                        <td>{{ $orderPro->product_size }}</td>
                        <td>{{ $orderPro->product_color }}</td>
                        <td>{{ $orderPro->product_price }}</td>
                        <td>{{ $orderPro->product_qty }}</td>
                        <td>{{ $orderPro->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
