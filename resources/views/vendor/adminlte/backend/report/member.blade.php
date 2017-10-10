@extends('adminlte::layouts.member')

@section('htmlheader_title')
    {{ trans('adminlte_lang::user.header_title') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Member: {{ $totalMem }}</h3>
                    <div class="box-tools pull-right">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="{{ Request::url() }}?type=1" class="btn btn-default" {{ ($type==1 ? 'disabled' : '') }}>Day</a>
                            <a href="{{ Request::url() }}?type=2" class="btn btn-default" {{ ($type==2 ? 'disabled' : '') }}>Week</a>
                            <a href="{{ Request::url() }}?type=3" class="btn btn-default" {{ ($type==3 ? 'disabled' : '') }}>Months</a>
                        </div>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="line-chart" style="height: 300px;"></div>
                </div>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/morris.js/morris.css">
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/raphael/raphael.min.js"></script>
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/morris.js/morris.min.js"></script>
    <script>
        $(function () {
            "use strict";
            // LINE CHART
            var line = new Morris.Line({
                element: 'line-chart',
                resize: true,
                data: {!! $chart['data'] !!},
                xkey: "date",
                ykeys:['totalPrice'],
                labels:['Total Price'],
                xLabels:'day',
                lineColors:['#3c8dbc'],
                hideHover : true
            });
        });
    </script>
@endsection