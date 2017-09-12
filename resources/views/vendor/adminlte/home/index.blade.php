@extends('adminlte::layouts.member')

@section('htmlheader_title')
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
                              <h4>150</h4>

                              <p>{{ trans('adminlte_lang::home.btc_wallet') }}</p>
                            </div>
                          </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green"  style="height: 80px">
                                <div class="inner">
                                  <h4>53<sup style="font-size: 20px"></h4>

                                  <p>{{ trans('adminlte_lang::home.clp_wallet') }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-green" style="height: 80px">
                            <div class="inner">
                              <h4>53<sup style="font-size: 20px"></h4>

                              <p>{{ trans('adminlte_lang::home.usd_wallet') }}</p>
                            </div>
                          </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-green" style="height: 80px">
                            <div class="inner">
                              <h4>53<sup style="font-size: 20px"></h4>

                              <p>{{ trans('adminlte_lang::home.re_invest_wallet') }}</p>
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
                        <center><h3 class="box-title">{{ trans('adminlte_lang::home.statistical_bussiness') }}</h3></center>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <center><h3 class="box-title">{{ trans('adminlte_lang::home.sale_f1') }}</h3></center>
                        <center><h5 class="box-title">{{ $data['newF1InWeek']}}</h5></center>
                        <center><h3 class="box-title">{{ trans('adminlte_lang::home.total_sale_f1') }}</h3></center>
                        <center><h5 class="box-title">{{ $data['totalF1User']}}</h5></center>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_left') }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_right') }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_left_new') }}<p>{{$data['leftNew']}}</p></div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_right_new') }}<p>{{$data['rightNew']}}</p></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_left_tichluy') }}
                                    <p>{{$data['totalF1UserLeft']}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-solid div-center">{{ trans('adminlte_lang::home.f1_right_tichluy') }}<p><p>{{$data['totalF1UserRight']}}</p></p>
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
                      <center><h3 class="box-title">{{ trans('adminlte_lang::home.trang_thai_dau_tu') }}</h3></center>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <center>
                            <h3 class="box-title">{{ trans('adminlte_lang::home.your_pack') }}</h3>
                            <p>Angel {{$data['package']}}</p>
                        </center>
                        <center>
                            <h3 class="box-title">{{ trans('adminlte_lang::home.value') }}</h3>
                            <p>${{$data['value']}}</p>
                        </center>
                        <center><h3 class="box-title">{{ trans('adminlte_lang::home.active') }}</h3></center>
                        <center><h3 class="box-title">{{ trans('adminlte_lang::home.release') }}</h3></center>
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