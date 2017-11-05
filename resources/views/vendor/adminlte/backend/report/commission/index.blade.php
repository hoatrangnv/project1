@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::user.report') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::user.commission') }}
@endsection

@section('main-content')
    {{--import css--}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/report/index.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    {{--import plugin--}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script>
        const DATA = {!! $data !!};
    </script>
    {{--BODY--}}
    <div class="row ">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    <div class="box-tools pull-right">
                        <input type="button" name="daterange">
                        <div class="btn-group btn-group-sm select-time" role="group" aria-label="Basic example">
                            <a class="link-day btn btn-default " href="" >Day</a>
                            <a class="link-week btn btn-default" href="" >Week</a>
                            <a class="link-month btn btn-default " href="" >Month</a>
                        </div>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="chart_div" style="height: 500px"></div>
                </div>
            </div>
        </div>
    </div>
    {{--END-BODY--}}
    {{--Chart--}}
    <script type="text/javascript" src="{{URL::asset('js/report/commission-chart-draw.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/report/commission-index.js')}}"></script>
@endsection