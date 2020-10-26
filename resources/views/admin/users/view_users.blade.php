@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb">
      <a href="{{route('admin.dashboard')}}" title="Go to Dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a>
     <a href="#" class="current">View Users</a> </div>
    <h1>Users</h1>
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
            <h5>View Users</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>user ID</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Country</th>
                  <th>Pincode</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Statue</th>
                  <th>Registered on</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($users as $user)
                    <tr class="gradeX">
                        <td class="text-center">{{$user->id}}</td>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->address }}</td>
                        <td class="text-center">{{ $user->city }}</td>
                        <td class="text-center">{{ $user->state }}</td>
                        <td class="text-center">{{ $user->country->name ?? "" }}</td>
                        <td class="text-center">{{ $user->pincode }}</td>
                        <td class="text-center">{{ $user->mobile }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{!! $user->status == 1? "<font color='green'>Active</font>":"<font color='red'>Inactive</font>" !!}</td>
                        <td class="center" width="8%">
                          {{$user->created_at->format('Y-m-d')}}
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
