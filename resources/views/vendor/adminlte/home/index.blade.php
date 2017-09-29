@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::home.dashboard') }}
@endsection

@section('custome_css')
<link rel="stylesheet" type="text/css" href="css/home.css">
<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css">-->
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header clp-dashboard">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ number_format(Auth::user()->userCoin->btcCoinAmount, 4) }}</h3>
                                    <p>{{ trans('adminlte_lang::home.btc_wallet') }}</p>
                                </div>
                                <div class="icon"><i class="fa fa-btc"></i></div>
                                <a href="{{ route('wallet.btc') }}" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                        <h3>{{ number_format(Auth::user()->userCoin->clpCoinAmount, 4) }}</h3>
                                        <p>{{ trans('adminlte_lang::home.clp_wallet') }}</p>
                                </div>
                                <div class="icon icon-clp">C</div>
                                <a href="{{ route('wallet.clp') }}" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3 class="usd-amount">{{ number_format(Auth::user()->userCoin->usdAmount, 2) }}</h3>
                                    <p>{{ trans('adminlte_lang::home.usd_wallet') }}</p>
                                </div>
                                <div class="icon"><i class="fa fa-usd"></i></div>
                                <a href="{{ route('wallet.usd') }}" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{ number_format(Auth::user()->userCoin->reinvestAmount, 2) }}</h3>
                                    <p>{{ trans('adminlte_lang::home.re_invest_wallet') }}</p>
                                </div>
                                <div class="icon"><i class="fa fa-usd"></i></div>
                                <a href="{{ route('wallet.reinvest') }}" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                            <center><h3 class="text-uppercase"><b>{{ trans('adminlte_lang::home.statistical_bussiness') }}</b></h3>
                            </center>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <table class="table table-bordered table-hover table-striped business-table">
                                    <tbody>
                                        <tr>
                                            <td class="text-right">
                                                <h4>{{ trans('adminlte_lang::home.sale_f1') }}
                                                </h4>
                                            </td>
                                            <td class="f1-sale">
                                                <b>{{ $data['newF1InWeek']}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                <h4>{{ trans('adminlte_lang::home.total_sale_f1') }}
                                                </h4>
                                            </td>
                                            <td class="f1-sale">
                                                <b>{{ $data['totalF1Sale'] }}</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-center"
                                         style="margin-bottom: 5px; font-weight: bold;">{{ trans('adminlte_lang::home.f1_left') }}</div>
                                    <table class="table table-bordered table-hover table-striped dataTable">
                                        <tbody>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.silver') }}</td>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.gold') }}</td>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.pear') }}</td>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.emerald') }}</td>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.diamond') }}</td>
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
                                            <td class="sale-right">
                                                <b>{{$data['leftNew']}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               {{ trans('adminlte_lang::home.f1_left_tichluy') }}
                                            </td>
                                            <td class="sale-right">
                                                <b>{{$data['leftOpen']}}</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center"
                                         style="margin-bottom: 5px; font-weight: bold;">{{ trans('adminlte_lang::home.f1_right') }}</div>
                                    <table class="table table-bordered table-hover table-striped dataTable">
                                        <tbody>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.silver') }}</td>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.gold') }}</td>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.pear') }}</td>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.emerald') }}</td>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.diamond') }}</td>
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
                                            <td class="sale-right">
                                                <b>{{$data['rightNew']}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               {{ trans('adminlte_lang::home.f1_right_tichluy') }}
                                            </td>
                                            <td  class="sale-right">
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
                            <center><h3 class="text-uppercase"><b>{{ trans('adminlte_lang::home.investment_status') }}</b></h3>
                            </center>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped award-table">
                                <tr>
                                    <td>
                                        {{ trans('adminlte_lang::home.your_pack') }}
                                    </td>
                                    <td  class="right text-uppercase">
                                        <b>{{ Auth::user()->userData->package ? Auth::user()->userData->package->name : '' }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       {{ trans('adminlte_lang::home.value') }}
                                    </td>
                                    <td  class="right">
                                        <b>{{ Auth::user()->userData->package ? '$'. number_format(Auth::user()->userData->package->price, 0) : '' }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       {{ trans('adminlte_lang::home.active') }}
                                    </td>
                                    <td  class="right">
                                        <b>{{ Auth::user()->userData->packageDate ? date("Y-m-d", strtotime(Auth::user()->userData->packageDate)) : '' }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       {{ trans('adminlte_lang::home.release') }}
                                    </td>
                                    <td  class="right">
                                        <b>{{ Auth::user()->userData->packageDate ? date("Y-m-d", strtotime(Auth::user()->userData->packageDate ."+ 180 days")) : '' }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       {{ trans('adminlte_lang::wallet.withdraw') }}
                                    </td>
                                    <td  class="right">
                                        <button class="btn btn-default bg-olive withdraw-package" 
                                                        data-id=""
                                                        data-toggle="confirmation" data-singleton="true"> {{ trans('adminlte_lang::wallet.withdraw') }}</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    @if(count($data["history_package"]) > 1)
                     <div class="box box-solid">
                        <div class="box-header with-border">
                            <center><h3 class="text-uppercase"><b>{{ trans('adminlte_lang::home.package_history') }}</b></h3>
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
                                            <td class="text-uppercase">
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
                    @endif
                </div>
                <!-- /.col (right) -->
            </div>
            

            <!-- end body -->
        </div>
    </div>
    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="errorwithdraw">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Holy guacamole!</strong> You should check in on some of those fields below.
    </div>
    <script>
        var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
      });
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function() {
                $.ajax({
                    beforeSend: function(){
                      // Handle the beforeSend event
                    },
                    url:"packages/withdraw",
                    type:"post",
                    data : {
                        type: "withdraw",
                        _token:  $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(result){
                        if(result.success){
                            $(".usd-amount").html(formatter.format(result.result).replace("$",""));
                            alert("{{ trans('adminlte_lang::wallet.success')}}");
                        }else{
                            alert(result.message);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("some error");
                    },
                    complete: function(){

                    }
                    // ......
                });
            },
            onCancel: function() {
               
            }
          });
    </script>
@endsection