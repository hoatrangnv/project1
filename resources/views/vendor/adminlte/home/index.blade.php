@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::home.dashboard') }}
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
                        <center><h3 class="box-title" style="font-size:18px; font-weight: bold;">{{ trans('adminlte_lang::home.sale_f1') }}&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $data['newF1InWeek']}}</b></h3></center>

                        <center><h3 class="box-title" style="font-size:18px; font-weight: bold;">{{ trans('adminlte_lang::home.total_sale_f1') }}&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ Auth::user()->userData->totalBonusLeft + Auth::user()->userData->totalBonusRight }}</b></h3></center>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box-solid div-center" style="margin-bottom: 5px; font-weight: bold;">{{ trans('adminlte_lang::home.f1_left') }}</div>
                                <table class="table table-bordered table-hover table-striped dataTable">
                                    <tbody>
                                        <tr>
                                            <td>Silver</td>
                                            <td>
                                                <?php
                                                    $lstSilverUser = [];
                                                    $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isSilver', 1)->where('leftRight', '=', 'left')->get();
                                                    foreach ($loyaltyUsers as $loyaltyUser){
                                                        $lstSilverUser[] = $loyaltyUser->user->name;
                                                    }
                                                    echo implode(', ', $lstSilverUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Gold</td>
                                            <td>
                                                <?php
                                                $lstGoldUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isGold', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser){
                                                    $lstGoldUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstGoldUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pear</td>
                                            <td>
                                                <?php
                                                $lstPearUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isPear', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser){
                                                    $lstPearUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstPearUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Emerald</td>
                                            <td>
                                                <?php
                                                $lstEmeraldUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isEmerald', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser){
                                                    $lstEmeraldUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstEmeraldUser);
                                                ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Diamond</td>
                                            <td>
                                                <?php
                                                $lstDiamondUser = [];
                                                $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isDiamond', 1)->where('leftRight', '=', 'left')->get();
                                                foreach ($loyaltyUsers as $loyaltyUser){
                                                    $lstDiamondUser[] = $loyaltyUser->user->name;
                                                }
                                                echo implode(', ', $lstDiamondUser);
                                                ;?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="div-center" style="margin-bottom: 5px; font-weight: bold;">{{ trans('adminlte_lang::home.f1_right') }}</div>
                                <table class="table table-bordered table-hover table-striped dataTable">
                                    <tbody>
                                    <tr>
                                        <td>Silver</td>
                                        <td>
                                            <?php
                                            $lstSilverUser = [];
                                            $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isSilver', 1)->where('leftRight', '=', 'right')->get();
                                            foreach ($loyaltyUsers as $loyaltyUser){
                                                $lstSilverUser[] = $loyaltyUser->user->name;
                                            }
                                            echo implode(', ', $lstSilverUser);
                                            ;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gold</td>
                                        <td>
                                            <?php
                                            $lstGoldUser = [];
                                            $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isGold', 1)->where('leftRight', '=', 'right')->get();
                                            foreach ($loyaltyUsers as $loyaltyUser){
                                                $lstGoldUser[] = $loyaltyUser->user->name;
                                            }
                                            echo implode(', ', $lstGoldUser);
                                            ;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pear</td>
                                        <td>
                                            <?php
                                            $lstPearUser = [];
                                            $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isPear', 1)->where('leftRight', '=', 'right')->get();
                                            foreach ($loyaltyUsers as $loyaltyUser){
                                                $lstPearUser[] = $loyaltyUser->user->name;
                                            }
                                            echo implode(', ', $lstPearUser);
                                            ;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Emerald</td>
                                        <td>
                                            <?php
                                            $lstEmeraldUser = [];
                                            $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isEmerald', 1)->where('leftRight', '=', 'right')->get();
                                            foreach ($loyaltyUsers as $loyaltyUser){
                                                $lstEmeraldUser[] = $loyaltyUser->user->name;
                                            }
                                            echo implode(', ', $lstEmeraldUser);
                                            ;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Diamond</td>
                                        <td>
                                            <?php
                                            $lstDiamondUser = [];
                                            $loyaltyUsers = \App\LoyaltyUser::where('refererId', '=', Auth::user()->id)->where('isDiamond', 1)->where('leftRight', '=', 'right')->get();
                                            foreach ($loyaltyUsers as $loyaltyUser){
                                                $lstDiamondUser[] = $loyaltyUser->user->name;
                                            }
                                            echo implode(', ', $lstDiamondUser);
                                            ;?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
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