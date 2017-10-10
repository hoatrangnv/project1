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
        &nbsp;
        <span class="" style="font-size: 18px;line-height: 50px;text-align: center;color: white">
            <b>
                <span>1 <i style="color: #FA890F">BTC</i> = $<span class="btcusd"></span></span>&nbsp;|&nbsp;
                <span>1 <i style="color: #FA890F">CLP</i> = $<span class="clpusd"></span></span>&nbsp;|&nbsp;
                <span>1 <i style="color: #FA890F">CLP</i> = <i class="fa fa-btc" aria-hidden="true"></i><span class="clpbtc"></span></span>
            </b>
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
                                        <!-- Message title and timestamp -->
                                        <h4>
                                            {{ trans('adminlte_lang::message.supteam') }}
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <!-- The message -->
                                        <p>{{ trans('adminlte_lang::message.awesometheme') }}</p>
                                    </a>
                                </li><!-- end message -->
                            </ul><!-- /.menu -->
                        </li>
                        <li class="footer"><a href="#">c</a></li>
                    </ul>
                </li><!-- /.messages-menu -->

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu" style="display: none">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('adminlte_lang::message.notifications') }}</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <li><!-- start notification -->
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> {{ trans('adminlte_lang::message.newmembers') }}
                                    </a>
                                </li><!-- end notification -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">{{ trans('adminlte_lang::message.viewall') }}</a></li>
                    </ul>
                </li>
                <!-- Tasks Menu -->
                <li class="dropdown tasks-menu" style="display: none">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('adminlte_lang::message.tasks') }}</li>
                        <li>
                            <!-- Inner menu: contains the tasks -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            {{ trans('adminlte_lang::message.tasks') }}
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <!-- The progress bar -->
                                        <div class="progress xs">
                                            <!-- Change the css width attribute to simulate progress -->
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% {{ trans('adminlte_lang::message.complete') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">{{ trans('adminlte_lang::message.alltasks') }}</a>
                        </li>
                    </ul>
                </li>
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
                                <p style="font-size: 14px;margin-bottom: 0px;margin-top: 0px;">ID <i>{{  Auth::user()->uid }}</i></p>
                                <p style="font-size: 14px;margin-bottom: 0px;margin-top: 0px;">Pack <i>{{ Auth::user()->userData->package->name }}</i></p>
                                <p style="font-size: 14px;margin-bottom: 0px;margin-top: 0px;">Loyalty <i>{{ config('cryptolanding.listLoyalty')[Auth::user()->userData->loyaltyId] }}</i></p>
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
    
    function doLogout(){
         document.cookie = "open=1";
    }
    
    function getTyGia(){
        $.ajax({
            dataType: "json",
            url: '{{ URL::to("exchange") }}',
            success: function(data){
               $('.btcusd').html(data[1].exchrate);
               $('.clpusd').html(data[2].exchrate);
               $('.clpbtc').html(data[0].exchrate);
               globalBTCUSD = data[1].exchrate;
               globalCLPUSD = data[2].exchrate; //clpUSD
               globalCLPBTC = data[0].exchrate;
            }
        });
    }
   
    $(function() {
        getTyGia();
        setInterval(function(){ getTyGia() }, {{ config('app.time_interval') }});
    });  
    
</script>
