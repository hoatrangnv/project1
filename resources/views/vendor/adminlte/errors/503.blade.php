@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.serviceunavailable') }}
@endsection

@section('main-content')

    <div class="error-page">
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> {{ trans('adminlte_lang::message.maintenance_mode') }}</h3>
            <p>
                {{ $message }}. @if($retryAfter) Please try back in {{ $retryAfter }} days @endif
            </p>
        </div>
    </div><!-- /.error-page -->
@endsection
