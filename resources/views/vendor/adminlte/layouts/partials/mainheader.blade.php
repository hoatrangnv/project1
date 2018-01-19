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
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="padding-right: 5px;">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        &nbsp;
        <span style="font-size: 14px;line-height: 50px;text-align: center;color: white">
            <span  class="hidden-xs" >1 <i style="color: #FA890F">BTC</i> = $<span class="btcusd"></span>&nbsp;|&nbsp;</span>
            <span>1 <i style="color: #FA890F">CLP</i> = $<span class="clpusd"></span></span>
            <span>&nbsp;|&nbsp;1 <i style="color: #FA890F">CLP</i> = <i class="fa fa-btc" aria-hidden="true"></i><span class="clpbtc"></span></span>
        </span>
       
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
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
            </ul>
        </div>
    </nav>
</header>


<!--modal buy package-->

    <div class="modal fade" id="buy-package" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">CLP Package</h4>
                </div>
                <form method="POST" action="http://127.0.0.1:8000/packages/invest" accept-charset="UTF-8" id="formPackage"><input name="_token" type="hidden" value="jt6ipUAtpG2fSbbJn5KUXEfPFZh2UHAZ3SGKU5nB">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                        @if(count($packages)>0)
                            @foreach($packages as $pKey=>$pVal)
                                <div class="col-md-4 m-b-lg">
                                      <div class="package-wrapper {{floatval($pKey+1)==Auth::user()->userData->packageId?'active':''}} {{strtolower($pVal->name)=='small'?'Small':strtolower($pVal->name)}}">
                                        <div class="package-title">
                                          <div class="package-logo">
                                            <img src="{{asset('img/p-'.strtolower($pVal->name).'.png')}}"/>
                                            {{$pVal->name}}
                                          </div>
                                        </div>
                                        <div class="package-content">
                                          <div class="item">
                                            <div class="h1 no-m">${{number_format($pVal->price,0)}}</div>
                                          </div>
                                          <div class="item display-flex justify-content-center">
                                            <span class="m-r-lg">Equivalent CLP<div class="h4 no-m"><b><span class="icon-clp-icon"></span><clp-1>{{number_format($pVal->price/$ExchangeRate['CLP_USD'],2)}}</clp-1></b></div></span>
                                            <span class="m-l-lg">Equivalent BTC<div class="h4 no-m"><b><span class="fa fa-btc"></span><btc-1>{{number_format($pVal->price/$ExchangeRate['BTC_USD'],5)}}</btc-1></b></div></span>
                                          </div>
                                          <div class="item">
                                            Reward<div class="h4 no-m"><b>{{$pVal->bonus*100}}% / Day</b></div>
                                          </div>
                                          <div class="item">
                                            <label class="iCheck">
                                              <input type="radio" value="{{$pVal->id}}" name="choose-package" {{floatval($pKey+1)==Auth::user()->userData->packageId?'checked':''}} class="flat-red">
                                              <span class="m-l-xxs">Choose</span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                            @endforeach
                        @else
                            <h1 class="text-center">There are no packages to buy</h1>
                        @endif
                        
                        
                    </div>
                  </div>
                </div>
                <div class="modal-footer p-h-lg" style="text-align: left;">
                   <div class="form-group">
                      <label class="iCheck">
                        <input type="checkbox" name="terms" id="termsPackage" class="flat-red">
                        <a class="m-l-xxs" href="/package-term-condition.html" target="_blank">Term and condition</a>
                      </label>
                      <span class="help-block error" id="package_term_error"></span>
                    </div>

                  <p>Buy Package by</p>
                    <button class="btn btn-success" data-wid="3" id="btn_submit_clp" type="button">CLP Wallet</button>
                    <button class="btn btn-success" data-wid="2" id="btn_submit_btc" type="button">BTC Wallet</button>
                    <button class="btn btn-default pull-right" id="btn_submit" type="button" data-dismiss="modal">Close</button>
                </form>
                {!! Form::open(['action'=>'UserOrderController@addNew','style'=>'display:none','id'=>'fBuy']) !!}
                    <input type="hidden" name="packageId" id="packageId"/>
                    <input type="hidden" name="walletId" id="walletId" />
                {!! Form::close() !!}
            </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

<!--end modal-->

<!--buy package script-->
<script src="{{asset('plugins/icheck/icheck.min.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var packageId = {{ Auth::user()->userData->packageId }};
        var packageIdPick = packageId;

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        })

        $('.package-wrapper').each(function(index, el) {
            $(el).hasClass('active') ? $(el) : $(el).addClass('disabled');
        });

        $('.iCheck,[name="choose-package"]+ins').click(function(event) {
            var _packageId=packageId;
            if(event.target.className=='iCheck-helper')
            {
                _packageId=$(this).parent().children('input[type="radio"]').val();
                packageIdPick=_packageId;
            }
            if(event.target.className=='m-l-xxs' || event.target.className=="iCheck hover")
            {
                _packageId=$(this).children().find('input[type="radio"]').val();
                packageIdPick=_packageId;
            }
            if (parseInt(_packageId)>0)
            {
                if (parseInt(_packageId) < parseInt(packageId))
                {
                    swal("Whoops","You can not downgrade package.","error");
                }
                if (_packageId == packageId) {
                    swal("Whoops","You purchased this package.","error");
                }
            }

            $('#packageId').val(_packageId);
            packageIdPick=_packageId;

            $('.package-wrapper').each(function(index, el) {
                $(el).hasClass('active') ? ($(el).removeClass('active'), $(el).addClass('disabled')) : $(el);
            });
            $(this).closest('.package-wrapper').removeClass('disabled');
            $(this).closest('.package-wrapper').addClass('active');



        });



        $('#btn_submit_clp, #btn_submit_btc').click(function(){
            $('#package_term_error').text('');
            var walletId=$(this).attr('data-wid');
            if (parseInt(packageIdPick)>0)
            {
                if (parseInt(packageIdPick) < parseInt(packageId))
                {
                    swal("Whoops","You can not downgrade package.","error");
                }
                else if (packageIdPick == packageId) {
                    swal("Whoops","You purchased this package.","error");
                }
                else 
                {
                    $('#walletId').val(walletId);
                    if($('#termsPackage').is(':checked'))
                    {
                        $('#buy-package').modal('hide');
                        swal({
                          title: "Are you sure?",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonClass: "btn-info",
                          confirmButtonText: "Yes, buy it!",
                          closeOnConfirm: false
                        },function(){
                          $('#fBuy').submit();
                        });
                    }
                    else
                    {
                        $('#package_term_error').text('Please checked term!');
                        return false;
                    }
                }
            }

        });

    });
</script>
<!--end buy package-->

<script>
    var formatter = new Intl.NumberFormat('en-US', {
            style: 'decimal',
            minimumFractionDigits: 2,
        });
    var formatterBTC = new Intl.NumberFormat('en-US', {
            style: 'decimal',
            minimumFractionDigits: 5,
        });
    function doLogout(){
         document.cookie = "open=1";
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // if url clp wallet get all value package
    @if (\Illuminate\Support\Facades\Request::is('wallets/clp'))
        @php
            $array = App\Package::all();
            $arr = [];
            foreach ($array as $a){
                array_push($arr,$a->price);
            }
            $arr = json_encode($arr);
        @endphp
    @endif


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

                // if url clp wallet update all table package modal
                @if (\Illuminate\Support\Facades\Request::is('wallets/clp'))
                     var array = JSON.parse('{{ $arr }}');
                     array.forEach(function (i,e) {
                       e++;
                       $('clp-'+e).html(formatter.format(i/data[2].exchrate));
                       $('btc-'+e).html(formatterBTC.format(i/data[1].exchrate));
                     })
                @endif
            }
        });
    }
   
    $(function() {
        getRate();
        setInterval(function(){ getRate() }, {{ config('app.time_interval') }});
    });  

    function getCountNewsNotRead()
    {
        storage = $.localStorage;
        var clpNews = {{ $aCLPNews }};

        //CLP News
        var arr_clp_news = new Array();
        arr_clp_news[0] = 1;
        if(storage.get("clp_news") != null) arr_clp_news = JSON.parse(JSON.stringify(storage.get("clp_news")));

        var count = 0;
        $.each(clpNews, function(index, value){
            if($.inArray(value, arr_clp_news) == -1)
            {
              count += 1;
            }
        });

        if(count > 0) {
            $("#has-news").text("New");
        }
    }

    $(document).ready(function (){
        getCountNewsNotRead();
    });
    
</script>
