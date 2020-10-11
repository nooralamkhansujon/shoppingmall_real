<!--sidebar-menu-->
@php
  $url = url()->current();
@endphp
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
  <li class="{{($url == route('admin.dashboard'))?'active':''}}" ><a href="{{route('admin.dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>

    <li class="submenu {{($url == route('admin.addCategory') || $url == route('admin.viewCategories'))? 'active':''}} "> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
      <ul>
        <li><a href="{{ url('/admin/add-category') }}">Add Category</a></li>
        <li><a href="{{ url('/admin/view-categories') }}">View Categories</a></li>
      </ul>
    </li>

    <li class="submenu {{($url == route('admin.addProduct') || $url == route('admin.viewProducts'))? 'active show':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> <span class="label label-important">2</span></a>
      <ul>
        <li><a href="{{ url('/admin/add-product') }}">Add Product</a></li>
        <li><a href="{{ url('/admin/view-products') }}">View Products</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
        <ul>
          <li><a href="{{ url('/admin/add-product') }}">Add Coupon</a></li>
          <li><a href="{{ url('/admin/view-products') }}">View Coupons</a></li>
        </ul>
    </li>

  </ul>
</div>
<!--sidebar-menu-->
