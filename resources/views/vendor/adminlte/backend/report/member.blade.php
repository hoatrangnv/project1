@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::user.report') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
    {{--import css--}}
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/report/index.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <style>
        .test {
           
            -webkit-animation-duration: 3s;
/*            -webkit-animation-delay: 3s;
            -webkit-animation-iteration-count: infinite;*/
          }
    </style>
    {{--import plugin--}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    @php $temp = json_decode($data); @endphp
    <script>
        var data = {!! $data !!};
        console.log(data);
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
                            <a href="{{ Request::url() }}?from_date={{$temp->date_custom->from_date}}&to_date={{$temp->date_custom->to_date}}&type={{$temp->type}}&opt=1" class="btn btn-default"{{ ($temp->opt==1 ? 'disabled' : '') }}>Day</a>
                            <a href="{{ Request::url() }}?from_date={{$temp->date_custom->from_date}}&to_date={{$temp->date_custom->to_date}}&type={{$temp->type}}&opt=2" class="btn btn-default"{{ ($temp->opt==2 ? 'disabled' : '') }}>Week</a>
                            <a href="{{ Request::url() }}?from_date={{$temp->date_custom->from_date}}&to_date={{$temp->date_custom->to_date}}&type={{$temp->type}}&opt=3" class="btn btn-default"{{ ($temp->opt==3 ? 'disabled' : '') }}>Months</a>
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
    {{--END-BODY--}}
    
    {{--Chart--}}
    <script type="text/javascript" src="{{URL::asset('js/report/chart-draw.js')}}"></script>
    {{--<script type="text/javascript" src="{{URL::asset('js/report/index.js')}}"></script>--}}
    <script>
        $('input[name="daterange"]').daterangepicker();
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            window.location.replace("{{ Request::url() }}?type={{$temp->type}}&opt={{$temp->opt}}&from_date="+picker.startDate.format('YYYY-MM-DD')+'&to_date='+picker.endDate.format('YYYY-MM-DD'));
        });
        var from_date = getFormatDate(data.date_custom.from_date);
        var to_date = getFormatDate(data.date_custom.to_date);
        $('input[name="daterange"]').data('daterangepicker').setStartDate(from_date);
        $('input[name="daterange"]').data('daterangepicker').setEndDate(to_date);
        function getFormatDate(date){
            date = new Date(date);
            return (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
        }
        var animationName = 'animated zoomIn';
        var animationend = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        
        $('.total-package').addClass(animationName).one(animationend, function() {
            $(this).removeClass(animationName);
         })
          
        $(function() {
            setInterval(function() {
              animationName = 'animated bounce'
              $('.total-package').addClass(animationName).one(animationend, function() {
                $(this).removeClass(animationName);
              });
            }, 1000);
          });
    </script>
@endsection