@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::home.dashboard') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::home.statistical') }}
    <style type="text/css">
        .div-center{
            text-align: center;
        }
    </style>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-aqua" style="height: 80px">
                            <div class="inner">
                                <center>
                                    <p style="font-size:20px">{{ trans('adminlte_lang::home.btc_wallet') }}</p>
                                    <h4 style="font-size:20px;font-weight:bold">{{ Auth::user()->userCoin->btcCoinAmount }}</h4>
                                </center>
                            </div>
                          </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green"  style="height: 80px">
                                <div class="inner">
                                    <center>
                                        <p style="font-size:20px">{{ trans('adminlte_lang::home.clp_wallet') }}</p>
                                        <h4 style="font-size:20px;font-weight:bold">{{ Auth::user()->userCoin->clpCoinAmount }}</h4>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-yellow" style="height: 80px">
                            <div class="inner">
                                <center>
                                    <p style="font-size:20px">{{ trans('adminlte_lang::home.usd_wallet') }}</p>
                                    <h4 style="font-size:20px;font-weight:bold">{{ Auth::user()->userCoin->usdAmount }}</h4>
                                </center>
                            </div>
                          </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-red" style="height: 80px">
                            <div class="inner">
                                <center>
                                    <p style="font-size:20px">{{ trans('adminlte_lang::home.re_invest_wallet') }}</p>
                                    <h4 style="font-size:20px;font-weight:bold">{{ Auth::user()->userCoin->reinvestAmount }}</h4>
                                </center>
                            </div>
                          </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
            <!-- body -->
           
            <div class="row">
                <div class="col-md-6">
                  <div class="box box-solid">
                    <div class="box-header with-border">
                        <center><h3 class="box-title" style="font-size:30px;font-weight: bold;">{{ trans('adminlte_lang::home.statistical_bussiness') }}</h3></center>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <center><h3 class="box-title" style="font-size:20px">{{ trans('adminlte_lang::home.sale_f1') }}&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $data['newF1InWeek']}}</b></h3></center>
                        <center><h5 class="box-title" style="font-size:10px">( Tính trong tuần hiện tại )</h5></center>

                        <center><h3 class="box-title" style="font-size:20px">{{ trans('adminlte_lang::home.total_sale_f1') }}&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $data['totalF1User']}}</b></h3></center>
                        <center><h5 class="box-title" style="font-size:10px">( Từ khi tham gia )</h5></center>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_left') }}<br><span style="font-size:10px">( List bạc - diamond )</span></div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_right') }}<br><span style="font-size:10px">( List bạc - diamond )</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_left_new') }}&nbsp;&nbsp;&nbsp;&nbsp;<b>{{$data['leftNew']}}</b></div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_right_new') }}&nbsp;&nbsp;&nbsp;&nbsp;<b>{{$data['rightNew']}}</b></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid div-center">
                                    {{ trans('adminlte_lang::home.f1_left_tichluy') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{$data['totalF1UserLeft']}}</b>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-solid div-center">
                                    {{ trans('adminlte_lang::home.f1_right_tichluy') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{$data['totalF1UserRight']}}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col (left) -->
                <div class="col-md-6">
                  <div class="box box-solid">
                    <div class="box-header with-border">
                      <center><h3 class="box-title" style="font-size:30px;font-weight: bold;">{{ trans('adminlte_lang::home.trang_thai_dau_tu') }}</h3></center>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <center>
                            <div class="row">
                                <div class="col-md-6"><h3 class="box-title" style="font-size:20px;">{{ trans('adminlte_lang::home.your_pack') }}</h3></div>
                                <div class="col-md-6"><h3 class="box-title" style="font-size:20px;font-weight: bold;">{{ Auth::user()->userData->package ? Auth::user()->userData->package->name : '' }}</h3></div>
                            </div>
                        </center>
                        <center>
                            <div class="row">
                                <div class="col-md-6"><h3 class="box-title" style="font-size:20px">{{ trans('adminlte_lang::home.value') }}</h3></div>
                                <div class="col-md-6"><h3 class="box-title" style="font-size:20px;font-weight: bold;">{{ Auth::user()->userData->package ? '&'.Auth::user()->userData->package->price : '' }}</h3></div>
                            </div>
                        </center>
                        <center>
                            <div class="row">
                                <div class="col-md-6"><h3 class="box-title" style="font-size:20px;">{{ trans('adminlte_lang::home.active') }}</h3></div>
                                <div class="col-md-6"><h3 class="box-title" style="font-size:20px;font-weight: bold;">{{ Auth::user()->userData->packageDate ? date("Y-m-d", strtotime(Auth::user()->userData->packageDate)) : '' }}</h3></div>
                            </div>
                        </center>
                        <center>
                            <div class="row">
                                <div class="col-md-6"><h3 class="box-title" style="font-size:20px;">{{ trans('adminlte_lang::home.release') }}</h3></div>
                                <div class="col-md-6"><h3 class="box-title" style="font-size:20px;font-weight: bold;">{{ Auth::user()->userData->packageDate ? date("Y-m-d", strtotime(Auth::user()->userData->packageDate ."+ 180 days")) : '' }}</h3></div>
                            </div>
                        </center>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col (right) -->
            </div>
          
            <!-- end body -->
        </div>
    </div>
@endsection