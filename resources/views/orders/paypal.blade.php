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
        <div class="heading text-center" >
            <h3>YOUR ORDER  HAS BEEN PLACED</h3>
            <p>Your order number is {{session()->get('order_id')}} and total payable about is BDT {{session()->get('grand_total')}}</p>
            <p>Please make payment by clicking on below Payment Button</p>
            @php
             $nameArr = explode(' ',$orderDetails->name);
            @endphp
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                {{-- <input type="hidden" name="cmd" value="_s-xclick"> --}}
                <input type="hidden" name="cmd" value="_xclick">
                {{-- <input type="hidden" name="hosted_button_id" value="6RNT8A4HBBJRE"> --}}
                <input type="hidden" name="business" value="nooralamkhansujon@gmail.com">

                <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_name" value="{{Session::get('order_id')}}">
                <input type="hidden" name="item_number" value="{{Session::get('order_id')}}">
                <input type="hidden" name="amount" value="{{Session::get('grand_total')}}">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="first_name"
                value="{{ $nameArr[0]}}">
                <input type="hidden" name="last_name"
                value="{{ $nameArr[1]}}">
                <input type="hidden" name="address1"
                value="{{$orderDetails->address}}">
                <input type="hidden" name="address2" value="Apt 5">
                <input type="hidden" name="city" value="{{$orderDetails->city}}">
                <input type="hidden" name="state" value="{{$orderDetails->state}}">
                <input type="hidden" name="zip" value="19312">
                <input type="hidden" name="night_phone_a" value="610">
                <input type="hidden" name="night_phone_b" value="555">
                <input type="hidden" name="night_phone_c" value="1234">
                <input type="hidden" name="email" value="{{$orderDetails->user_email}}">
                <input type="hidden" name="country" value="{{$orderDetails->country->name}}">
                <input type="hidden" name="return" value="{{route('paypal.thanks')}}">
                <input type="hidden" name="cancel_return" value="{{route('paypal.cancel')}}">

                <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Buy Now">
                <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>

        </div>
    </div>
</section>

@endsection
