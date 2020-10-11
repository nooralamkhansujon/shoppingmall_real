@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{route('admin.dashboard')}}" title="Go to Dasbhoard" class="tip-bottom"><i class="icon-home"></i> Dasbhoard</a>
    <a href="{{route('admin.viewProducts')}}" >Products</a>
    <a href="#" disabled class="current">Edit Product</a> </div>
    <h1>Products</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Product</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.editProduct',$productDetails->id) }}" name="edit_product" id="edit_product" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Select Category</label>
                  <div class="controls">
                    <select name="category_id" id="category_id" style="width: 220px;">
                      <?php echo $categories_dropdown; ?>
                    </select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Product Name</label>
                  <div class="controls">
                  <input type="text" name="product_name" value="{{ $productDetails->product_name }}" id="product_name">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Product Code</label>
                  <div class="controls">
                    <input type="text" name="product_code" value="{{ $productDetails->product_code }}" id="product_code">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Product Color</label>
                  <div class="controls">
                    <input type="text" name="product_color" value="{{ $productDetails->product_color}}" id="product_color">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Description</label>
                  <div class="controls">
                    <textarea name="description" value="{{ $productDetails->description }}" id="description"></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Price</label>
                  <div class="controls">
                  <input type="text" name="price" value="{{$productDetails->price}}" id="price">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Image</label>
                  <div class="controls">
                    <input type="file" name="image" id="image" >
                    <span>
                        <img src="{{asset('images/backend_images/products/small/'.$productDetails->image)}}"
                         width="80" height="80" alt="">
                    </span>
                  </div>

                </div>
                <div class="control-group">
                    <label class="control-label">Status</label>
                    <div class="controls">
                      <input type="checkbox" name="status" id="status" {{($productDetails->status == '1')?'checked':""}} value="1" >
                    </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Edit Product" class="btn btn-success">
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
