@extends('layouts.frontLayout.front_design')

@section('content')
<section id="form"><!--form-->
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
        <form action="{{route('checkout')}}" id="checkoutForm"  method="post">
            @csrf
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form" ><!--login form-->
                        <h2>Billing To</h2>
                        <div class="form-group">
                            <input type="text"  name="billing_name" value="{{$user->name}}" class="form-control" id="billing_name"  placeholder="Billing Name"/>
                        </div>
                        <div class="form-group">
                            <input type="text"  name="billing_address" value="{{$user->address}}" class="form-control" id="billing_address"  placeholder="Billing Address"/>
                        </div>
                        <div class="form-group">
                            <input type="text"  name="billing_city"
                            value="{{$user->city}}" class="form-control" id="billing_city"  placeholder="Billing City"/>
                        </div>
                        <div class="form-group">
                            <input type="text"  name="billing_state" value="{{$user->state}}" class="form-control" id="billing_state"  placeholder="Billing State"/>
                        </div>
                        <div class="form-group">
                            <select name="billing_country_id" id="billing_country_id" class="form-control">
                                <option value="0" disabled selected>Select Country</option>
                                @foreach($countries as $country)
                                    @if(isset($user->country->id))
                                        <option {{$user->country->id == $country->id ? 'selected':""}} value="{{$country->id}}">{{$country->name}}</option>
                                    @else
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text"  name="billing_pincode" value="{{$user->pincode}}" class="form-control" id="billing_pincode"  placeholder="Billing Pincode"/>
                        </div>
                        <div class="form-group">
                            <input type="text"
                             name="billing_mobile" value="{{$user->mobile}}" class="form-control" id="billing_mobile"  placeholder="Billing Mobile"/>
                        </div>
                        <div class="form-check">
                           <input type="checkbox" class="form-check-input" id="billingtoshipping">
                           <label for="billingtoshipping" class="form-check-label">Shipping Address same as a Billing address </label>
                        </div>

                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>Shipping To</h2>
                        <div class="form-group">
                            <input type="text"  name="shipping_name" class="form-control" id="shipping_name"
                            value="{{$shippingDetails->name ?? ""}}"  placeholder="Shipping Name"/>
                        </div>
                        <div class="form-group">
                            <input type="text"  name="shipping_address" class="form-control" id="shipping_address"  value="{{$shippingDetails->address ?? ""}}" placeholder="Shipping Address"/>
                        </div>
                        <div class="form-group">
                             <input type="text"  name="shipping_city" class="form-control"
                             value="{{ $shippingDetails->city ?? ""}}" id="shipping_city"  placeholder="Shipping City"/>
                        </div>
                        <div class="form-group">
                            <input type="text"  name="shipping_state" class="form-control" id="shipping_state"
                            value="{{$shippingDetails->state ?? ""}}" placeholder="Shipping State"/>
                        </div>
                        <div class="form-group">
                            <select name="shipping_country_id" id="shipping_country_id" class="form-control">
                                <option value="0" disabled selected>Select Country</option>
                                @foreach($countries as $country)
                                   @if(isset($shippingDetails) && !empty($shippingDetails))
                                     <option {{$shippingDetails->country_id  == $country->id?"selected":""}} value="{{$country->id}}">{{$country->name}}</option>
                                   @else
                                      <option value="{{$country->id}}">{{$country->name}}</option>
                                   @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text"  name="shipping_pincode" class="form-control" id="shipping_pincode" value="{{$shippingDetails->pincode ?? ""}}"  placeholder="Shipping Pincode"/>
                        </div>
                        <div class="form-group">
                            <input type="text"  name="shipping_mobile"  class="form-control" id="shipping_mobile" value="{{$shippingDetails->mobile ?? ""}}"  placeholder="Shipping Mobile"/>
                        </div>
                        <button type="submit" style="margin-top:0px;margin-left:0px;" class="btn btn-default check_out">Checkout</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
