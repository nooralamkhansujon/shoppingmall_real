@extends('layouts.frontLayout.front_design')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Order Review</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="shopper-informations">
            <div class="row">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-1">
                        <div class="login-form">
                            <h2>Billing Details</h2>
                            <div class="form-group">
                                {{$userDetails->name}}
                            </div>
                            <div class="form-group">
                                {{$userDetails->address}}
                            </div>
                            <div class="form-group">
                                {{$userDetails->city}}
                            </div>
                            <div class="form-group">
                                {{$userDetails->state}}
                            </div>
                            <div class="form-group">
                                    {{$userDetails->country->name}}
                            </div>
                            <div class="form-group">
                                {{$userDetails->pincode}}
                            </div>
                            <div class="form-group">
                                {{$userDetails->mobile}}
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="signup-form">
                            <h2>Shipping Details</h2>
                            <div class="form-group">
                                {{$shippingDetails->name}}
                            </div>
                            <div class="form-group">
                                {{$shippingDetails->address ?? ""}}
                            </div>
                            <div class="form-group">
                                {{ $shippingDetails->city ?? ""}}
                            </div>
                            <div class="form-group">
                                {{$shippingDetails->state ?? ""}}
                            </div>
                            <div class="form-group">
                                {{$shippingDetails->country->name }}
                            </div>
                            <div class="form-group">
                                {{$shippingDetails->pincode ?? ""}}
                            </div>
                            <div class="form-group">
                                {{$shippingDetails->mobile ?? ""}}
                            </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-payment">
            <h2>Review & Payment</h2>
        </div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description">Item Name</td>
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
                    @foreach($orderItems as $item)
                        <tr>
                            <td >
                               <a href=""><img style="width:100px; height:100px;" src="{{asset('images/backend_images/products/small/'.$item->product->image)}}" alt=""></a>
                            </td>
                            <td class="cart_description">
                              <h4><a href="">{{$item->product_name}}</a></h4>
                               <p>Size : {{$item->size}}</p>
                            </td>
                            <td class="cart_price">
                                <p>Tk.{{$item->price}}</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <a class="cart_quantity_up" href="{{route('front.updateQuantity',[$item->id,'1'])}}"> + </a>
                                    <input class="cart_quantity_input" type="text" disabled name="quantity" value="{{$item->quantity}}" autocomplete="off" size="2">
                                     @if($item->quantity > 1)
                                        <a class="cart_quantity_down" href="{{route('front.updateQuantity',[$item->id,'-1'])}}"> - </a>
                                      @endif
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">Tk.{{$item->price*$item->quantity}}</p>
                            </td>
                            <td class="cart_delete">
                                <a href="{{route('front.deleteCartItem',$item->id)}}" class="cart_quantity_delete" ><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        @php
                           $total_amount += $item->price*$item->quantity;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">


                                        <tr>
                                            <td>Cart Sub Total</td>
                                            <td>Tk.{{$total_amount}}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Cost</td>
                                            <td>Tk. 0 </td>
                                        </tr>
                                        <tr>
                                            <td>Coupon Discount</td>
                                            @if(session()->has('couponAmount'))
                                                <td>Tk.{{session()->get('couponAmount')}}</td>
                                            @else
                                               <td>Tk. 0 </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @php
                                                $grand_total = 0;
                                            @endphp
                                            <td>Grand Total</td>
                                            @if(session()->has('couponAmount'))
                                                <td>Tk.{{$total_amount - session()->get('couponAmount')}}</td>
                                                @php
                                                  $grand_total = $total_amount - session()->get('couponAmount');
                                                @endphp
                                            @else
                                                <td>Tk.{{$total_amount}}</td>
                                                @php
                                                  $grand_total = $total_amount;
                                                @endphp
                                            @endif
                                        </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form action="{{route('placeOrder')}}" name="paymentForm" id="paymentForm" method="POST" >
            @csrf
           <div class="payment-options">
           <input type="hidden" name="grand_total" value="{{$grand_total}}">
                <span>
                    <label><strong>Select Payment Method:</strong></label>
                </span>
                <span>
                    <label><input type="radio" name="payment_method" id="COD" value="COD"> <strong>COD</strong> </label>
                </span>
                <span>
                    <label><input type="radio" name="payment_method" id="Paypal" value="Paypal"> <strong>Paypal</strong></label>
                </span>
                <span style="float:right;">
                    <button type="submit" style="margin-top:0px;margin-left:0px;" onclick="return selectPaymentMethod(event);" class="btn btn-default check_out">Place Order</button>
                </span>
            </div>
        </form>
    </div>
</section> <!--/#cart_items-->
@endsection
