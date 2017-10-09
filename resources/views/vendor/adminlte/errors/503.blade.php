@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.serviceunavailable') }}
@endsection

@section('main-content')

    <div class="error-page">
        <h2 class="headline text-red">300</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> {{ trans('adminlte_lang::message.maintenance_mode') }}</h3>
            <p>
                {{ $exception->getMessage(); }}. Please try back in {{ $exception->retryAfter }}
            </p>
        </div>
    </div><!-- /.error-page -->
@endsection
