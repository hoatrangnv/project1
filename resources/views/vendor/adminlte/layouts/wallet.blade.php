<div class="box">
    <div class="box-header clp-dashboard">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ number_format(Auth::user()->userCoin->btcCoinAmount, 5) }}</h3>
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
                            <h3>{{ number_format(Auth::user()->userCoin->clpCoinAmount, 2) }}</h3>
                            <p>{{ trans('adminlte_lang::home.clp_wallet') }}</p>
                    </div>
                    <div class="icon"><span class="icon-clp-icon"></span></div>
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
                    <div class="icon"><span class="icon-clp-icon"></span></div>
                    <a href="{{ route('wallet.reinvest') }}" class="small-box-footer">{{ trans('adminlte_lang::home.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
</div>