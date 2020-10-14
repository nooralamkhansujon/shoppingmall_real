@extends('layouts.frontLayout.front_design')

@section('content')

	<section>
		<div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('front.index')}}">Home</a></li>
                    <li class="active">Product Details</li>
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
			<div class="row">
				<div class="col-sm-3">
					@include('layouts.frontLayout.front_sidebar')
				</div>

				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                <a href="{{asset('images/backend_images/products/large/'.$productDetails->image)}}">
                                    <img id="mainImage"  src="{{asset('images/backend_images/products/medium/'.$productDetails->image)}}" alt=""  />
                                </a>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">

								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="item active thumbnails">
                                            <a href="{{asset('images/backend_images/products/large/'.$productDetails->image)}}" data-standard="{{asset('images/backend_images/products/small/'.$productDetails->image)}}">
                                                <img class="changeImage" style="width:80px;cursor:pointer;" src="{{asset('images/backend_images/products/small/'.$productDetails->image)}}" alt="">
                                            </a>
                                            @foreach($productDetails->altImages as $altImage)
                                                <a href="{{asset('images/backend_images/products/large/'.$altImage->image)}}" data-standard="{{asset('images/backend_images/products/small/'.$altImage->image)}}">
                                                    <img class="changeImage" style="width:80px;cursor:pointer;" src="{{asset('images/backend_images/products/small/'.$altImage->image)}}" alt="">
                                                </a>
                                            @endforeach
										</div>
									</div>
							</div>

						</div>
						<div class="col-sm-7">
                            <form action="{{route('front.addToCart',$productDetails->id)}}" id="addToCartForm" method="POST">
                                @csrf
                                <div class="product-information"><!--/product-information-->
                                    <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                                    <h2>{{$productDetails->product_name}}</h2>
                                    <p><strong>Product Code:</strong> {{$productDetails->product_code}}</p>
                                    <p>
                                    <select data-productid="{{$productDetails->id}}" name="attribute" id="size" style="width:200px;">
                                            <option value="" disabled selected>Select Size</option>
                                            @foreach($productDetails->attributes as $attribute)
                                            <option  value="{{$attribute->id}}">{{$attribute->size}}</option>
                                        @endforeach
                                    </select>
                                    </p>
                                    <img src="images/product-details/rating.png" alt="" />

                                    <span>
                                        <span id="getPrice" style="font-size:25px;">TK {{$productDetails->price}}</span>
                                        <label>Quantity:</label>
                                        <input type="text" value="1" min="1" name="quantity" />
                                        @if($totalStock > 0)
                                            <button type="submit" id="addToCart" type="button" class="btn btn-fefault cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                Add to cart
                                            </button>
                                        @endif
                                    </span>

                                    <p><b>Availability:</b><span id="stock"> {{$totalStock > 0 ? 'In Stock':"Out Of Stock"}}</span></p>
                                    <p><b>Condition:</b> New</p>
                                </div><!--/product-information-->
                            </form>
						</div>
					</div><!--/product-details-->

					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#description" data-toggle="tab">Description</a></li>
								<li><a href="#care" data-toggle="tab">Material & Care</a></li>
								<li><a href="#delivary" data-toggle="tab">Delivery Options</a></li>
								<li ><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade in active " id="description" >
                                <div class="col-md-12">
                                    <p class="ml-3">{{ $productDetails->description }}</p>
                                </div>
							</div>

							<div class="tab-pane fade " id="care" >
                                <div class="col-md-12">
                                    <p class="ml-3">{{ $productDetails->care ?? "No Content" }}</p>
                                </div>
							</div>

							<div class="tab-pane fade" id="delivary" >
                                <div class="col-md-12">
                                    <p class="ml-3">You will pay monay after getting products</p>
                                </div>
							</div>

							<div class="tab-pane fade" id="reviews" >
								<div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
									</ul>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									<p><b>Write Your Review</b></p>

									<form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
										<textarea name="" ></textarea>
										<b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
										<button type="button" class="btn btn-default pull-right">
											Submit
										</button>
									</form>
								</div>
							</div>

						</div>
					</div><!--/category-tab-->

					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>

						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
                                @foreach($relatedProducts->chunk(3) as $products)

                                        <div class="item {{$loop->first?"active":"0"}}">
                                            @foreach($products as $product)
                                                <div class="col-sm-4">
                                                    <div class="product-image-wrapper">
                                                        <div class="single-products">
                                                            <div class="productinfo text-center">
                                                                <img src="{{asset('images/backend_images/products/small/'.$product->image)}}" alt="" />
                                                                <h2>TK. {{$product->price}}</h2>
                                                                <p>{{$product->product_name}}</p>
                                                                <a href="{{route('front.productDetails',$product->id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                @endforeach
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>
						</div>
					</div><!--/recommended_items-->

				</div>
			</div>
		</div>
	</section>


@endsection
