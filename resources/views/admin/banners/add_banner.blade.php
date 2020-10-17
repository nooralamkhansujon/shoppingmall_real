@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb">
      <a href="{{route('admin.dashboard')}}" title="Go to Dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a>
      <a href="{{route('admin.viewBanners')}}">Banners</a>
      <a href="#" class="current" disabled>Add Banner</a>
   </div>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Banner</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ route('admin.addBanner') }}" enctype="multipart/form-data" name="add_banner" id="add_banner" novalidate="novalidate">
                @csrf
              <div class="control-group">
                <label class="control-label">Banner title</label>
                <div class="controls">
                  <input type="text" name="title" id="title">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Banner Link</label>
                <div class="controls">
                  <input type="text" name="link" id="link">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Banner image</label>
                <div class="controls">
                  <input type="file" name="image" id="image">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Status</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1" >
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Add Banner" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
