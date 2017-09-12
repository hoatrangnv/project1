@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::user.header_title') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                {!! Form::open(['route' => ['users.store'] ]) !!}
                <div class="box-header"></div>
                <div class="box-body" style="padding-top:0;">
                    @include('user._form')
                </div>
                <div class="box-footer">
                    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection