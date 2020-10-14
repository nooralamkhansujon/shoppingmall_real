@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="{{route('admin.dashboard')}}" title="Go to Dashboard" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="{{route('admin.viewProducts')}}">Products</a>
        <a href="#" class="current" disabled>Add Product Image </a>
    </div>
    <h1>Products</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_error') !!}</strong>
        </div>
    @endif
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Product Alt Images</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{route('admin.addProductImage',$productDetails->id)}}" >
                 @csrf
                <div class="control-group">
                    <label class="control-label"><strong>Product Name</strong></label>
                    <label class="control-label">
                        {{$productDetails->product_name}}
                    </label>
                </div>
                <div class="control-group">
                    <label class="control-label"><strong>Product Code</strong></label>
                    <label class="control-label">
                        {{$productDetails->product_code}}
                    </label>
                </div>
                <div class="control-group">
                    <label class="control-label"><strong>Product Color</strong></label>
                    <label class="control-label">
                        {{$productDetails->product_color}}
                    </label>
                </div>
                <div class="control-group">
                    <label class="control-label"><strong>Product Color</strong></label>
                    <label class="control-label">
                       <img style="width:150px;height:150px;" src="{{asset('images/backend_images/products/small/'.$productDetails->image)}}" alt="">
                    </label>
                </div>
                <div class="control-group">
                    <label class="control-label"><strong>Add Alt Images </strong><small>( You can upload Multiple Image )</small></label>
                    <div class="row controls">
                        <div class="col-md-6">
                            <div>
                                <input type="file" name="images[]" multiple>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="form-actions">
                <input type="submit" value="Add Alt Image" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="span12">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View {{$productDetails->product_name}}'s Alt Images</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                     <th>Image ID</th>
                     <th>Product Id</th>
                    <th>Alt Image</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($productDetails->altImages as $altImage)
                        <tr class="gradeX">
                            <td>{{ $altImage->id }}</td>
                            <td>{{ $altImage->product_id }}</td>
                            <td>
                                <img style="width:100px;height:100px;" src="{{asset('images/backend_images/products/small/'.$altImage->image)}}" alt="">
                            <td>
                                <a rel="{{$altImage->id}}" rel1="delete-altimage"
                                    href="{{route('admin.deleteAltImage',$altImage->id)}}"
                                    class="btn btn-danger btn-mini deleteRecord">Delete</a>
                            </td>
                        </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>


@endsection
