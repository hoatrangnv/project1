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
            <span class="hidden-xs" >1 <i style="color: #FA890F">BTC</i> = $<span class="btcusd"></span>&nbsp;|&nbsp;</span>
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
                    @if( sizeof(Config::get('languages')) > 1)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Config::get('languages')[App::getLocale()] }}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach( Config::get('languages') as $loc => $lang )
                            <li>
                                <a href="{{ url('/language/') . '/' . $loc }}">{{ $lang }} </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif


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
                                    <div class="col-md-6 col-xs-6" style="padding-right: 0px;"><span style="float: right;">{{ trans('adminlte_lang::profile.id') }}:&nbsp</span></div>
                                    <div class="col-md-6 col-xs-6" style="padding-left: 0px;"><i style="float: left;">{{  Auth::user()->uid }}</i></div>
                                </div>
                                <div class="row" style="color:white">
                                    <div class="col-md-6 col-xs-6" style="padding-right: 0px;"><span style="float: right;">{{ trans('adminlte_lang::profile.pack') }}:&nbsp</span></div>
                                    <div class="col-md-6 col-xs-6" style="padding-left: 0px;"><i style="float: left;">@if(isset(Auth::user()->userData->package->name)){{ Auth::user()->userData->package->name }}@endif</i></div>
                                </div>
                                <div class="row" style="color:white">
                                    <div class="col-md-6 col-xs-6" style="padding-right: 0px;"><span style="float: right;">{{ trans('adminlte_lang::profile.loyalty') }}:&nbsp</span></div>
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
                <form method="" action="" accept-charset="UTF-8" id="formPackage">
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
                                                <span class="text-center">Equivalent CLP
                                                    <div class="h4 no-m">
                                                        <b>
                                                            <span class="icon-clp-icon"></span>
                                                            @if(Config('params.fixCLPUSDTable') && !empty($ExchangeTable))
                                                            <clp-1>{{number_format($ExchangeTable[$pVal->id-1],2)}}</clp-1>
                                                            @else
                                                            <clp-1>{{number_format($pVal->price/$ExchangeRate['CLP_USD'],2)}}</clp-1>
                                                            @endif
                                                        </b>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="item">
                                                <span class="text-center">Equivalent BTC
                                                    <div class="h4 no-m">
                                                        <b>
                                                            <span class="fa fa-btc"></span>
                                                            <btc-1>{{number_format($pVal->price/$ExchangeRate['BTC_USD'],8)}}</btc-1>
                                                        </b>
                                                    </div>
                                                </span>
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
                    <button class="btn btn-success" data-wid="1" id="btn_submit_btc" type="button">USD Wallet</button>
                    <button class="btn btn-default pull-right" id="btn_submit" type="button" data-dismiss="modal">Close</button>
                </form>
                
            </div>
            </div>
        </div>
        
    </div>
    {!! Form::open(['action'=>'UserOrderController@addNew','style'=>'display:none','id'=>'fBuy']) !!}
            <input type="hidden" name="packageId" id="packageId"/>
            <input type="hidden" name="walletId" id="walletId" />
        {!! Form::close() !!}

<!--buy package script-->
<script src="{{asset('plugins/icheck/icheck.min.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var ua = navigator.userAgent;
        window.iOS = /iPad|iPhone|iPod/.test(ua),
        window.iOS11 = /OS 11_0_1|OS 11_0_2|OS 11_0_3|OS 11_1|OS 11_1_1|OS 11_1_2|OS 11_2|OS 11_2_1|OS 11_2_2|OS 11_2_5/.test(ua);
        jQuery(document).on('click','.btn-buyPack',function(){
            if ( window.iOS && window.iOS11 )
            {
                window.location.href="{{URL::to('packages/ibuy')}}";
            }
            else
            {
                //$('#buy-package').modal('show');
                $.post('{{URL::to("orders/check-order")}}',function(response){
                    var rsp=$.parseJSON(response);
                    if(rsp.status==true)
                    {
                        $('#buy-package').modal('show');
                    }
                    else
                    {
                        swal('Whoops','You are unable to create an order or buy a new package, since your buy '+rsp.data+' package order is not completed yet. Please complete or cancel that order then try again.','error');
                    }
                });
            }
        });

        var packageId = {{ Auth::user()->userData->packageId }};
        var packName = "{{isset(Auth::user()->userData->package->name)?Auth::user()->userData->package->name:''}}";
        var packageIdPick = packageId;
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        })

        $('.package-wrapper').each(function(index, el) {
            $(el).hasClass('active') ? $(el) : $(el).addClass('disabled');
        });

        $('#buy-package').on('hidden.bs.modal', function () {
            $('#termsPackage').prop('checked',false);
            $('#package_term_error').text('');
            $('#packageId').val(packageId);
            packageIdPick=packageId;
            $('.package-wrapper').addClass('disabled');
            $('[name="choose-package"]').removeAttr('checked');
            $('.iCheck .checked').removeClass('checked');
            $('.package-wrapper').each(function(index, el) {
                let oldP=$(this).children().find('[name="choose-package"]');

                if(oldP.val()==packageId)
                {
                    $(this).removeClass('disabled');
                    $(this).addClass('active');
                    oldP.attr('checked',true);
                    oldP.parent().addClass('checked');
                }
                //$(el).hasClass('active') ? ($(el).removeClass('active'), $(el).addClass('disabled')) : $(el);
            });
            //$(this).closest('.package-wrapper').removeClass('disabled');
            //$(this).closest('.package-wrapper').addClass('active');

        });

        jQuery('.item .iCheck, [name="choose-package"]+ins').click(function(event) {
            $('[name="choose-package"]').removeAttr('checked');
            $('[name="choose-package"]').parent().removeClass('checked');

            var _packageId=packageId;
            if(event.target.className=='iCheck-helper')
            {
                _packageId=$(this).parent().children('input[type="radio"]').val();
                $(this).parent().children('input[type="radio"]').attr('checked',true);//add checked
                $(this).parent().children('input[type="radio"]').parent().addClass('checked');
                packageIdPick=_packageId;
            }
            if(event.target.className=='m-l-xxs' || event.target.className=="iCheck hover")
            {
                _packageId=$(this).children().find('input[type="radio"]').val();
                $(this).children().find('input[type="radio"]').attr('checked',true);
                $(this).children().find('input[type="radio"]').parent().addClass('checked');
                packageIdPick=_packageId;
            }
            if (parseInt(_packageId)>0)
            {
                if (parseInt(_packageId) < parseInt(packageId))
                {
                    swal("Whoops","Your current package is "+packName+". You are unable to downgrade the package.","error");
                }
                if (_packageId == packageId) {
                    swal("Whoops","You have already purchased this package. Please try again with the larger package or go back if your current package is Angel.","error");
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



        jQuery('#btn_submit_clp, #btn_submit_btc').click(function(){
            $('#package_term_error').text('');
            var walletId=$(this).attr('data-wid');
            if (parseInt(packageIdPick)>0)
            {
                if (parseInt(packageIdPick) < parseInt(packageId))
                {
                    swal("Whoops","Your current package is "+packName+". You are unable to downgrade the package.","error");
                }
                else if (packageIdPick == packageId) {
                    swal("Whoops","You have already purchased this package. Please try again with the larger package or go back if your current package is Angel","error");
                }
                else 
                {
                    $('#walletId').val(walletId);

                    if($('#termsPackage').is(':checked')==true)
                    {
                        $.post('{{URL::to("orders/check-order")}}',function(response){
                            var rsp=$.parseJSON(response);
                            if(rsp.status==false)
                            {
                                swal('Whoops','You are unable to create an order or buy a new package, since your buy '+rsp.data+' package order is not completed yet. Please complete or cancel that order then try again.','error');
                                return false;
                            }
                            else
                            {
                                //check balance
                                $.post('{{route("order.checkBalance")}}',{_token:'{{csrf_token()}}',pid:packageIdPick,wallet:walletId},function(response){
                                    var response=$.parseJSON(response);
                                    if(response.status==true)
                                    {
                                        var action='buy';
                                        if(packageId>0)//upgrade
                                            action='upgrade to';
                                        var title=""
                                        if(walletId==1) {
                                            title='Are you going to '+action+' '+response.packName+' package. '+response.packPriceUSD+' USD will be deducted in your wallet.';
                                        } else if (walletId==2) {
                                            title='Are you going to '+action+' '+response.packName+' package. '+response.packPriceBTC+' BTC will be deducted in your wallet.';
                                        } else {
                                            title='Are you going to '+action+' '+response.packName+' package. '+response.packPriceCLP+' CLP will be deducted in your wallet.';
                                        }
                                        swal({
                                            title:title,
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonClass: "btn-info",
                                            confirmButtonText: "Yes",
                                            closeOnConfirm: false
                                        },function(){
                                            jQuery('#fBuy').submit();
                                        });
                                    }
                                    else if(response.status==false){
                                        if(walletId==1) {
                                            title='Your USD balance is not sufficient. Would you like to put an order and pay later?';
                                        } else if(walletId==2) {
                                            title='Your BTC balance is not sufficient. Would you like to put an order and pay later?';
                                        } else {
                                            title='Your CLP balance is not sufficient. Would you like to put an order and pay later?';
                                        }
                                        swal({
                                            title:title,
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonClass: "btn-info",
                                            confirmButtonText: "Yes",
                                            closeOnConfirm: false
                                        },function(){
                                            jQuery('#fBuy').submit();
                                        });
                                    }
                                    else
                                    {
                                        swal("Error","Whoops. Look like something went wrong","error");
                                    }
                                });
                                //
                            }
                        });

                        

                        
                    }
                    else
                    {
                        var act='buy';
                        if(packageId>0)
                            act='upgrade';
                        $('#package_term_error').text('In order to '+act+' package, you must read and check the Term and Condition!');
                        return false;
                    }
                }
            }
            else
            {
                swal("Error","Please choose a package!","error");
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
                $('.btcusd').html(formatter.format(data[4].exchrate));
                $('.clpusd').html(formatterBTC.format(data[5].exchrate));
                $('.clpbtc').html(formatterBTC.format(data[3].exchrate));
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
