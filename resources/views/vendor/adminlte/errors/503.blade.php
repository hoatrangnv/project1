@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.serviceunavailable') }}
@endsection

@section('main-content')

    <div class="error-page">
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> {{ trans('adminlte_lang::message.maintenance_mode') }}</h3>
            <p>
                We are integrating our system with the public exchange platform, so we are temporary postponing. We are sorry about this inconvenience caused and will overcome this issue in soonest. We will back on 11/14/2017.
            </p>
        </div>
    </div><!-- /.error-page -->
@endsection
