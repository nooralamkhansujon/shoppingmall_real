@extends('layouts.frontLayout.front_design')

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('flash_message_error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_error') !!}</strong>
                        </div>
                   @endif
                    @if(Session::has('flash_message_success'))
                        <div class="alert alert-success ">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_success') !!}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Product Image</td>
                            <td class="description">Product Name</td>
                            <td class="price">Price</td>
                            <td class="quantity">Quantity</td>
                            <td class="total">Total</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                          $total_amount = 0;
                        @endphp
                        @foreach($cartProducts as $cart)
                            <tr>
                                <td class="cart_product">
                                    <a href="">
                                        <img style="width:100px; height:100px;" src="{{asset('images/backend_images/products/small/'.$cart->product->image)}}" alt="">
                                    </a>
                                </td>
                                <td class="cart_description">
                                   <h6><a href="">{{$cart->product_name}}</a></h4>
                                    <p>{{$cart->product_code}}</p>
                                    <p>Size: {{$cart->size}}</p>
                                </td>
                                <td class="cart_price">
                                    <p>TK. {{$cart->price}}</p>
                                </td>
                                <td class="cart_quantity">

                                    <div class="cart_quantity_button">
                                      <a class="cart_quantity_up" href="{{route('front.updateQuantity',[$cart->id,'1'])}}"> + </a>
                                      <input class="cart_quantity_input" type="text" disabled name="quantity" value="{{$cart->quantity}}" autocomplete="off" size="2">
                                       @if($cart->quantity > 1)
                                          <a class="cart_quantity_down" href="{{route('front.updateQuantity',[$cart->id,'-1'])}}"> - </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">Tk. {{$cart->price*$cart->quantity}}</p>
                                </td>
                                <td class="cart_delete">
                                   <a href="{{route('front.deleteCartItem',$cart->id)}}" class="cart_quantity_delete" ><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @php
                               $total_amount+= $cart->price*$cart->quantity;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->

    <section id="do_action">
        <div class="container">
            <div class="heading">
                <h3>What would you like to do next?</h3>
                <p>Check if you have a coupon code you want to use </p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="chose_area">
                        <ul class="user_option">
                            <li>
                                <label>Coupon Code</label>
                                <form action="{{route('front.applyCoupon')}}" method="post">
                                    @csrf
                                    <input type="text" name="coupon_code">
                                    <input type="submit" value="Apply" class="btn btn-default">
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            @if(session()->has('couponAmount'))
                                @php
                                  echo Session::get('couponAmount')
                                @endphp
                               <li>Sub Total <span>Tk. {{$total_amount}}</span></li>
                               <li>Coupon Discount <span>{{session()->get('couponAmount')}}</span></li>
                               <li>Grand Total <span>Tk. {{$total_amount - session()->get('couponAmount')}}</span></li>
                            @else
                                <li>Grand Total <span>Tk.{{$total_amount}}</span></li>
                            @endif
                        </ul>
                            <a class="btn btn-default update" href="">Update</a>
                            <a class="btn btn-default check_out" href="">Check Out</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action-->

@endsection
