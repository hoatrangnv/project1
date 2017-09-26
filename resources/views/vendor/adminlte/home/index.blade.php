@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::home.dashboard') }}
@endsection
<style type="text/css">
    .box-solid .box-title {
        font-size: 18px;
        text-transform: uppercase;
        margin-top: 0;
        padding: 7px 10px;
        text-align: center;
    }
</style>
<link rel="stylesheet" type="text/css" href="css/home.css">
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <center>
                                        <p style="font-size:20px">{{ trans('adminlte_lang::home.btc_wallet') }}</p>
                                        <h4 style="font-size:20px;font-weight:bold">{{ Auth::user()->userCoin->btcCoinAmount }}</h4>
                                    </center>
                                </div>
                                <a href="#" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <center>
                                        <p style="font-size:20px">{{ trans('adminlte_lang::home.clp_wallet') }}</p>
                                        <h4 style="font-size:20px;font-weight:bold">{{ Auth::user()->userCoin->clpCoinAmount }}</h4>
                                    </center>
                                </div>
                                <a href="#" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <center>
                                        <p style="font-size:20px">{{ trans('adminlte_lang::home.usd_wallet') }}</p>
                                        <h4 style="font-size:20px;font-weight:bold">{{ Auth::user()->userCoin->usdAmount }}</h4>
                                    </center>
                                </div>
                                <a href="#" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <center>
                                        <p style="font-size:20px">{{ trans('adminlte_lang::home.re_invest_wallet') }}</p>
                                        <h4 style="font-size:20px;font-weight:bold">{{ Auth::user()->userCoin->reinvestAmount }}</h4>
                                    </center>
                                </div>
                                <a href="#" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                            <center><h3 class="box-title">{{ trans('adminlte_lang::home.statistical_bussiness') }}</h3>
                            </center>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <table class="table table-bordered table-hover table-striped business-table">
                                    <tbody>
                                        <tr>
                                            <td class="fl-right">
                                                <h3 class="box-title">{{ trans('adminlte_lang::home.sale_f1') }}
                                                </h3>
                                            </td>
                                            <td>
                                                <b>{{ $data['newF1InWeek']}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fl-right">
                                                <h3 class="box-title">{{ trans('adminlte_lang::home.total_sale_f1') }}
                                                </h3>
                                            </td>
                                            <td>
                                                <b>{{ $data['totalF1Sale'] }}</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box-solid div-center"
                                         style="margin-bottom: 5px; font-weight: bold;">{{ trans('adminlte_lang::home.f1_left') }}</div>
                                    <table class="table table-bordered table-hover table-striped dataTable">
                                        <tbody>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.silver') }}</td>
                                            <td>
                                                <?php
                                                $lstSilverUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isSilver', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstSilverUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstSilverUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.gold') }}</td>
                                            <td>
                                                <?php
                                                $lstGoldUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isGold', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstGoldUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstGoldUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.pear') }}</td>
                                            <td>
                                                <?php
                                                $lstPearUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isPear', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstPearUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstPearUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.emerald') }}</td>
                                            <td>
                                                <?php
                                                $lstEmeraldUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isEmerald', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstEmeraldUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstEmeraldUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.diamond') }}</td>
                                            <td>
                                                <?php
                                                $lstDiamondUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isDiamond', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstDiamondUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstDiamondUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-hover table-striped award-table">
                                        <tr>
                                            <td>
                                                {{ trans('adminlte_lang::home.f1_left_new') }}
                                            </td>
                                            <td>
                                                <b>{{$data['leftNew']}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               {{ trans('adminlte_lang::home.f1_left_tichluy') }}
                                            </td>
                                            <td>
                                                <b>{{$data['leftOpen']}}</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="div-center"
                                         style="margin-bottom: 5px; font-weight: bold;">{{ trans('adminlte_lang::home.f1_right') }}</div>
                                    <table class="table table-bordered table-hover table-striped dataTable">
                                        <tbody>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.silver') }}</td>
                                            <td>
                                                <?php
                                                $lstSilverUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isSilver', 1)->where('leftRight', '=', 'right')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstSilverUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstSilverUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.gold') }}</td>
                                            <td>
                                                <?php
                                                $lstGoldUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isGold', 1)->where('leftRight', '=', 'right')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstGoldUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstGoldUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.pear') }}</td>
                                            <td>
                                                <?php
                                                $lstPearUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isPear', 1)->where('leftRight', '=', 'right')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstPearUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstPearUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.emerald') }}</td>
                                            <td>
                                                <?php
                                                $lstEmeraldUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isEmerald', 1)->where('leftRight', '=', 'right')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstEmeraldUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstEmeraldUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('adminlte_lang::home.diamond') }}</td>
                                            <td>
                                                <?php
                                                $lstDiamondUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isDiamond', 1)->where('leftRight', '=', 'right')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser) {
                                                    $lstDiamondUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstDiamondUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-hover table-striped award-table">
                                        <tr>
                                            <td>
                                                {{ trans('adminlte_lang::home.f1_right_new') }}
                                            </td>
                                            <td  class="right">
                                                <b>{{$data['rightNew']}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               {{ trans('adminlte_lang::home.f1_right_tichluy') }}
                                            </td>
                                            <td  class="right">
                                                <b>{{$data['rightOpen']}}</b>
                                            </td>
                                        </tr>
                                    </table>
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
                            <center><h3 class="box-title">{{ trans('adminlte_lang::home.investment_status') }}</h3>
                            </center>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"><h3 class="">{{ trans('adminlte_lang::home.your_pack') }}</h3>
                                </div>
                                <div class="col-md-6"><span
                                            class="">{{ Auth::user()->userData->package ? Auth::user()->userData->package->name : '' }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><h3 class="">{{ trans('adminlte_lang::home.value') }}</h3></div>
                                <div class="col-md-6"><h3
                                            class="">{{ Auth::user()->userData->package ? '$'.Auth::user()->userData->package->price : '' }}</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><h3 class="">{{ trans('adminlte_lang::home.active') }}</h3></div>
                                <div class="col-md-6"><h3
                                            class="">{{ Auth::user()->userData->packageDate ? date("Y-m-d", strtotime(Auth::user()->userData->packageDate)) : '' }}</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><h3 class="">{{ trans('adminlte_lang::home.release') }}</h3></div>
                                <div class="col-md-6"><h3
                                            class="">{{ Auth::user()->userData->packageDate ? date("Y-m-d", strtotime(Auth::user()->userData->packageDate ."+ 180 days")) : '' }}</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                     <div class="box box-solid">
                        <div class="box-header with-border">
                            <center><h3 class="box-title">{{ trans('adminlte_lang::home.package_history') }}</h3>
                            </center>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>{{ trans('adminlte_lang::home.package') }}</th>
                                        <th>{{ trans('adminlte_lang::home.buy_date') }}</th>
                                        <th>{{ trans('adminlte_lang::home.release_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $data["history_package"] as $package)
                                        <tr>
                                            <td>
                                            {{ $package->name }}
                                            </td>
                                            <td>
                                            {{  date("Y-m-d", strtotime($package->buy_date)) }}
                                            </td>
                                            <td>
                                            {{  date("Y-m-d", strtotime($package->release_date)) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.col (right) -->
            </div>

            <!-- end body -->
        </div>
    </div>
@endsection