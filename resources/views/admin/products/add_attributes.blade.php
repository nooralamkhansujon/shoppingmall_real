@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb">
      <a href="{{route('admin.dashboard')}}" title="Go to Dashboard" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="{{route('admin.viewProducts')}}">Products</a>
        <a href="#" class="current" disabled>Add Product</a> </div>
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
            <h5>Add Product Products Attribute</h5>
          </div>
          <div class="widget-content nopadding">
            <form  class="form-horizontal" method="post" action="{{ route('admin.addProductAttribute',$productDetails->id) }}" >
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
                  <label class="control-label"><strong>Add Attributes</strong></label>
                  <div class="row controls">
                      <div class="col-md-6">
                          <div class="attribute-wrapper">
                              <div class="input-group">
                                  <input style="width:100px;" type="text" name="sku[]" placeholder="sku" class="form-control"  required>
                                  <input style="width:100px;" type="text" name="size[]" placeholder="size" class="form-control" required>
                                  <input style="width:100px;" type="text" name="stock[]" placeholder="stock" class="form-control" required>
                                  <input style="width:100px;" type="text" name="price[]" placeholder="price" class="form-control" required>
                                  <button  type="button" class="btn btn-success btn-mini add_button">Add</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="form-actions">
                <input type="submit" value="Add Product" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="span12">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View {{$productDetails->product_name}}'s Attribute</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Attribute ID</th>
                    <th>SKU</th>
                    <th>Size</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                {{-- </form> --}}
                  @foreach($productDetails->Attributes as $attribute)
                        <tr class="gradeX">
                            <form action="{{route('admin.updateAttribute',$attribute->id)}}" id="{{$attribute->id}}"  method="post">
                            @csrf
                            <td>{{ $attribute->id }}</td>
                            <td>{{ $attribute->sku }}</td>
                            <td>{{ $attribute->size }}</td>
                            <td>
                                <input type="text" name="stock" value="{{ $attribute->stock }}">
                            </td>
                            <td><input type="text" name="price" value="{{ $attribute->price }}"></td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-mini">update</button>
                                <a rel="{{$attribute->id}}" rel1="delete-attribute"
                                    href="{{route('admin.deleteAttribute',$attribute->id)}}"
                                    class="btn btn-danger btn-mini deleteRecord">Delete</a>
                            </td>
                          </form>
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
