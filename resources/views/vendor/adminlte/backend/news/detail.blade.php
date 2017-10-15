@extends('adminlte::layouts.member')

@section('contentheader_title')
   <?php 
   use App\Http\Controllers\News\DisplayNewsController;
   $newsTitle = new DisplayNewsController();
  
   ?>
   {{  $newsTitle->category[$data->category_id] }}
@endsection

@section('main-content')
    @if ( session()->has("errorMessage") )
        <div class="callout callout-danger">
            <h4>Warning!</h4>
            <p>{!! session("errorMessage") !!}</p>
        </div>
        {{ session()->forget('errorMessage') }}
    @elseif ( session()->has("successMessage") )
        <div class="callout callout-success">
            <h4>Success</h4>
            <p>{!! session("successMessage") !!}</p>
        </div>
        {{ session()->forget('successMessage') }}
    @else
        <div></div>
    @endif
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $data->title }}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! $data->desc !!}
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
             
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
@endsection