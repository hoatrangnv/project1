@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::news.add') }}
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
    
    {{ Form::open(array('url' => 'news'))}}
    <!-- Title of Post Form Input -->
    <div class="form-group @if ($errors->has('title')) has-error @endif">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title of Post']) !!}
        @if ($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
    </div>
    <!-- Type of Post Form Input -->
    <div class="form-group @if ($errors->has('category')) has-error @endif">
        {!! Form::label('title', 'Category') !!}
        {!! Form::select('category',  array(
            '3' => trans('adminlte_lang::news.clp_news')
        ), '1', ['class' => 'form-control']) !!}
        @if ($errors->has('category')) <p class="help-block">{{ $errors->first('category') }}</p> @endif
    </div>

    <!-- Text body Form Input -->
    <div class="form-group @if ($errors->has('body')) has-error @endif">
        {!! Form::label('body', 'Body') !!}
        {!! Form::textarea('body', null, ['class' => 'form-control ckeditor','placeholder' => 'Body of Post...']) !!}
        @if ($errors->has('body')) <p class="help-block">{{ $errors->first('body') }}</p> @endif
    </div>
    <div>
        {{ Form::submit(trans('adminlte_lang::news.add_button'), array('class' => 'btn btn-primary')) }}
    </div>
    {{ Form::close() }}
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'body' );
    </script>
@endsection