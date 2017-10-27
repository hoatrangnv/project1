@extends('adminlte::backend.layouts.member')

@section('htmlheader_title')
    {{ trans('adminlte_lang::user.header_title') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
    {{--import css--}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/report/index.css')}}" />
    {{--import plugin--}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    {{--Chart line--}}
    <script>
        var type = @if($type){!! $type !!}@else null @endif;
        var data = {!! $data !!};
        var dataPackage = {!!  $dataPackage !!};
    </script>
    <script type="text/javascript" src="{{URL::asset('js/report/chart-draw.js')}}"></script>
    <div class="row ">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Member: {{ $totalMem }}</h3>
                    <div class="box-tools pull-right">
                        <input type="button" name="daterange">
                        <div class="btn-group btn-group-sm select-time" role="group" aria-label="Basic example">
                            <a href="{{ Request::url() }}?type=1" class="btn btn-default" {{ ($type==1 ? 'disabled' : '') }}>Day</a>
                            <a href="{{ Request::url() }}?type=2" class="btn btn-default" {{ ($type==2 ? 'disabled' : '') }}>Week</a>
                            <a href="{{ Request::url() }}?type=3" class="btn btn-default" {{ ($type==3 ? 'disabled' : '') }}>Months</a>
                        </div>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="chart_div" ></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            @include('adminlte::backend.report.views.subreport')
        </div>

        <div class="col-md-4 ">
            <div class="chart" id="piechart_3d"></div>
        </div>
    </div>

    <script type="text/javascript" src="{{URL::asset('js/report/index.js')}}"></script>
@endsection