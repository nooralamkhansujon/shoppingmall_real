@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{route('admin.dashboard')}}" title="Go to Dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a>
        <a href="#" disabled class="current">View Banners</a> </div>
    <h1>Banners</h1>
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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Banners</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Banner ID</th>
                  <th>Banner Title</th>
                  <th>Banner Link</th>
                  <th>Banner Image</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($banners as $banner)
                <tr class="gradeX">
                  <td>{{ $banner->id }}</td>
                  <td>{{ $banner->title }}</td>
                  <td>{{ $banner->link }}</td>
                  <td><img src="{{asset('images/frontend_images/banners/'.$banner->image)}}" style="width:100px;height:100px;" alt=""></td>
                  <td>{{ $banner->status ==1 ?"Active":"InActive" }}</td>
                  <td class="center">
                      <a href="{{ route('admin.editBanner',$banner->id) }}" class="btn btn-primary btn-mini">Edit</a>
                  <a rel="{{$banner->id}}" rel1="delete-banner" href="javascript:void(0)" class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
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
