@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::news.edit') }}
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
    
    {{ Form::open(array('url' => 'news/'.$news->id , 'method' => 'PUT'))}}
    <!-- Title of Post Form Input -->
    <div class="form-group @if ($errors->has('title')) has-error @endif">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text(
            'title', 
            $news->title, 
            [ 
                'class' => 'form-control', 
                'placeholder' => 'Title of Post'
            ]) 
        !!}
        @if ($errors->has('title')) 
            <p class="help-block">
                {{ $errors->first('title') }}
            </p> 
        @endif
    </div>
    
    <!-- Category of Post Form Input -->
    <div class="form-group @if ($errors->has('category')) has-error @endif">
        {!! Form::label('title', 'Category') !!}
        {!! Form::select('category',  array(
            '1' => trans('adminlte_lang::news.crypto_news'), 
            '2' => trans('adminlte_lang::news.blockchain_news'),
            '3' => trans('adminlte_lang::news.clp_news'),
            '4' => trans('adminlte_lang::news.p2p_news')
        ), $news->category_id, ['class' => 'form-control']) !!}
        @if ($errors->has('category')) <p class="help-block">{{ $errors->first('category') }}</p> @endif
    </div>

    <!-- Text body Form Input -->
    <div class="form-group @if ($errors->has('body')) has-error @endif">
        {!! Form::label('body', 'Body') !!}
        {!! Form::textarea(
            'body', 
            $news->desc, 
            [
                'class' => 'form-control ckeditor',
                'placeholder' => 'Body of Post...'
            ]) 
        !!}
        @if ($errors->has('body')) <p class="help-block">{{ $errors->first('body') }}</p> @endif
    </div>
    <div>
        {{ Form::submit(trans('adminlte_lang::news.save_button'), array('class' => 'btn btn-primary')) }}
    </div>
    {{ Form::close() }}
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'body' );
    </script>
@endsection