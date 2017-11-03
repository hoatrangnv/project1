@extends('adminlte::backend.layouts.member')

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
    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $data->title }}</h3>
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
      </div>
      </div>
        <!-- /.col -->
@endsection