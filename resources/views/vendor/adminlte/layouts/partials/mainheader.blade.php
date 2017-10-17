<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{ url('/') }}/img/logo_gold.png"/></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{ url('/') }}/img/logo_gold.png"/><b>CLP</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        &nbsp;
        <span class="hidden-xs" style="font-size: 14px;line-height: 50px;text-align: center;color: white">
            <span>1 <i style="color: #FA890F">BTC</i> = $<span class="btcusd"></span></span>&nbsp;|&nbsp;
            <span>1 <i style="color: #FA890F">CLP</i> = $<span class="clpusd"></span></span>&nbsp;|&nbsp;
            <span>1 <i style="color: #FA890F">CLP</i> = <i class="fa fa-btc" aria-hidden="true"></i><span class="clpbtc"></span></span>
        </span>
       
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu" style="display: none">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('adminlte_lang::message.tabmessages') }}</li>
                        <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <!-- User Image -->
                                            <img src="{{ Gravatar::get(Auth()->user()->email) }}" class="img-circle" alt="User Image"/>
                                        </div>
                                    </a>
                                </li><!-- end message -->
                            </ul><!-- /.menu -->
                        </li>
                    </ul>
                </li><!-- /.messages-menu -->

                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu" id="user_menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ Gravatar::get(Auth()->user()->email) }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header" style="height: 190px;">
                                <img src="{{ Gravatar::get(Auth()->user()->email) }}" class="img-circle" alt="User Image" />
                                <p style="font-size: 16px;margin-bottom: 0px;margin-top: 0px;">{{ Auth::user()->name }}</p>
                                <div class="row" style="color:white">
                                    <div class="col-md-6 col-xs-6" style="padding-right: 0px;"><span style="float: right;">ID:&nbsp</span></div>
                                    <div class="col-md-6 col-xs-6" style="padding-left: 0px;"><i style="float: left;">{{  Auth::user()->uid }}</i></div>
                                </div>
                                <div class="row" style="color:white">
                                    <div class="col-md-6 col-xs-6" style="padding-right: 0px;"><span style="float: right;">Pack:&nbsp</span></div>
                                    <div class="col-md-6 col-xs-6" style="padding-left: 0px;"><i style="float: left;">@if(isset(Auth::user()->userData->package->name)){{ Auth::user()->userData->package->name }}@endif</i></div>
                                </div>
                                <div class="row" style="color:white">
                                    <div class="col-md-6 col-xs-6" style="padding-right: 0px;"><span style="float: right;">Loyalty:&nbsp</span></div>
                                    <div class="col-md-6 col-xs-6" style="padding-left: 0px;"><i style="float: left;">@if(Auth::user()->userData->loyaltyId){{ config('cryptolanding.listLoyalty')[Auth::user()->userData->loyaltyId] }}@endif</i></div>
                                </div>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat" id="logout"
                                       onclick="event.preventDefault();
                                                doLogout();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('adminlte_lang::message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar" class="clp-news"><i class="fa fa-newspaper-o"></i>&nbsp{{ trans('adminlte_lang::news.title_news') }}</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script>
    var formatter = new Intl.NumberFormat('en-US', {
            style: 'decimal',
            minimumFractionDigits: 2,
        });
    var formatterBTC = new Intl.NumberFormat('en-US', {
            style: 'decimal',
            minimumFractionDigits: 8,
        });
    function doLogout(){
         document.cookie = "open=1";
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    function getRate(){
        $.ajax({
            dataType: "json",
            url: '{{ URL::to("exchange") }}',
            success: function(data){
               $('.btcusd').html(formatter.format(data[1].exchrate));
               $('.clpusd').html(formatter.format(data[2].exchrate));
               $('.clpbtc').html(formatterBTC.format(data[0].exchrate));
               $('.clpbtcsell').html(formatterBTC.format(data[0].exchrate * 0.95));
               globalBTCUSD = data[1].exchrate;
               globalCLPUSD = data[2].exchrate; //clpUSD
               globalCLPBTC = data[0].exchrate;
            }
        });
    }
   
    $(function() {
        getRate();
        setInterval(function(){ getRate() }, {{ config('app.time_interval') }});
    });  
    
</script>
