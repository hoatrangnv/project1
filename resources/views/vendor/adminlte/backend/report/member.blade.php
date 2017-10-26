@extends('adminlte::backend.layouts.member')

@section('htmlheader_title')
    {{ trans('adminlte_lang::user.header_title') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <script type="text/javascript">
        var format;
        var type = @if($type){!! $type !!}@else null @endif;
        var title;
        if (type == 1) {
            format = "HH:mm"
            title = 'In Day'
        } else if (type == 2) {
            format = "d"
            title = 'In Week'
        } else if (type == 3) {
            format = "d/M"
            title = 'In Month'
        } else {
            format = "d/M"
            title = 'FromDay ' + '{!! $from_date !!}' + ' ToDay ' + '{!! $to_date !!}'
        }
        var data = {!! $data !!};
        var arrayData = [];
        data.forEach(function(element) {
            arrayData.push([ new Date( moment(element.date).unix() * 1000),Number(element.totalPrice) ])
        });

        google.charts.load("visualization", "1", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var obj = arrayData;
            var data = new google.visualization.DataTable();
            data.addColumn({type: 'datetime', label: 'Date'});
            data.addColumn({type: 'number', label: 'Buy'});
            data.addRows(obj)
            var options = {
                curveType: "function",
                vAxis: {maxValue: 100},
                title: title,
                hAxis: {
                    format: format
                    //format: "HH:mm:ss"
                    //format:'MMM d, y'
                },
                explorer: {
                    actions: ['dragToZoom', 'rightClickToReset'],
                    axis: 'vertical'
                },
                focusTarget:'category',
                aggregationTarget : 'category',
                pointSize: 5,
            };

            var chart = new google.visualization.LineChart(
                document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Member: {{ $totalMem }}</h3>
                    <div class="box-tools pull-right">
                        <input type="button" name="daterange">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
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

    <script>
        $('input[name="daterange"]').daterangepicker();
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            window.location.replace("{{ Request::url() }}?from_date="+picker.startDate.format('YYYY-MM-DD')+'&to_date='+picker.endDate.format('YYYY-MM-DD'));
        });
    </script>
@endsection