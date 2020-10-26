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
            <h3>YOUR COD  ORDER  HAS BEEN PLACED</h3>
            <h3>Thanks for the payment. We will process your order very soon</h3>
            <p>Your order number is {{session()->get('order_id')}} and total amount paid is BDT {{session()->get('grand_total')}}</p>
        </div>
    </div>
</section>

@endsection
