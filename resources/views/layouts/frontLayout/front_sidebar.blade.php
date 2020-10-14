<div class="left-sidebar">
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        @foreach($categories as $category)
            @if($category->Categories->count() > 0 )
               @if($category->status == 'Active')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#{{$category->name}}">
                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            {{$category->name}}
                            </a>
                        </h4>
                    </div>
                    <div id="{{$category->name}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach($category->Categories as $subCategory)
                                   @if($subCategory->status == 'Active')
                                      <li><a href="{{route('productsByCategory',$subCategory->url)}}">{{$subCategory->name}}</a></li>
                                   @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                  </div>
                @endif
            @else
                @if($category->status == 'Active')
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="{{route('productsByCategory',$category->url)}}">{{$category->name}}</a></h4>
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    </div><!--/category-products-->
</div>
