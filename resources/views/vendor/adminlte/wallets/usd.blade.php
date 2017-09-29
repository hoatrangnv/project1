@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.header_title') }}
@endsection

@section('main-content')

    <!--    captrue error-->
    @if ( session()->has("errorMessage") )
        <div class="callout callout-danger">
            <h4>Warning!</h4>
            <p>{!! session("errorMessage") !!}</p>
        </div>
        {{ session()->forget('errorMessage') }}
    @elseif ( session()->has("successMessage") )
        <div class="callout callout-success">
            <h4>Success</h4>
            <p>{!! session("successMessage") !!}</p>
        </div>
        {{ session()->forget('successMessage') }}
    @else
        <div></div>
    @endif
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="row">
        <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
          <div class="box">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped wallet-table">
                        <tr>
                            <th class="icon-wallet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg>
                            </th>
                            <th class="wallet-amount">@isset($wallets->currencyPair)<i class="fa fa-usd" aria-hidden="true"></i>{{ $wallets->currencyPair }}  @endisset</th>
                            <th><button class="btn bg-olive" data-toggle="modal" data-target="#modal-default">{{ trans('adminlte_lang::wallet.tranfer_to_clp') }}</button></th>
                        </tr>
                    </table>
                </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
    </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-2 no-padding">
                        {{ Form::select('wallet_type', array_merge(['0' => 'Choose a type'], $wallet_type), ($requestQuery && isset($requestQuery['type']) ? $requestQuery['type'] : 0), ['class' => 'form-control input-sm', 'id' => 'wallet_type']) }}
                    </div>
                    <div class="col-xs-1">
                        {!! Form::button('Filter', ['class' => 'btn btn-sm btn-primary', 'id' => 'btn_filter']) !!}
                    </div>
                </div>
                <div class="box-body" style="padding-top:0;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped dataTable">
                        <tr>
                            <th>{{ trans('adminlte_lang::wallet.wallet_no') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_date') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_type') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_in') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_out') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_info') }}</th>
                        </tr>
                        <tbody>
                            @foreach ($wallets as $key => $wallet)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $wallet->created_at }}</td> 
                                <td>
                                    {{ $wallet_type && isset($wallet_type[$wallet->type]) ? $wallet_type[$wallet->type] : '' }}
                                </td>
                                <td>
                                    @if($wallet->inOut=='in')
                                        {{ $wallet->amount }}
                                    @endif
                                </td>
                                <td>
                                    @if($wallet->inOut=='out')
                                        {{ $wallet->amount }}
                                    @endif
                                </td>
                                <td>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="text-center">
                            {{ $wallets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--fORM submit-->
    <form class="form-horizontal" _lpchecked="1" method="post" action="">
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{ trans('adminlte_lang::wallet.tranfer_to_clp') }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="max" data-type="usdwallet">1000<span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">USD</label>

                                <div class="col-sm-10">
                                  <input type="number" step="0.01" class="form-control switch-USD-to-CLP" id="inputEmail3" name="usd" placeholder="USD" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">CLP</label>

                                <div class="col-sm-10">
                                  <input type="number" step="0.000000001" class="form-control switch-CLP-to-USD" id="inputPassword3" name="clp" placeholder="CLP" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
          <!-- /.modal-dialog -->
        </div>
    </form>
    <!-- /.modal -->
    <script>
        $(document).ready(function(){
            $('#btn_filter').on('click', function () {
                var wallet_type = parseInt($('#wallet_type option:selected').val());
                if(wallet_type > 0){
                    location.href = '{{ url()->current() }}?type='+wallet_type;
                }else{
                    alert('Please choose a type!');
                    return false;
                }
            })
        });
        // var getRateBtcUsd = setInterval(function(){ 
        //     updateRateBtcUsd(); 
        // }, {{ config("app.time_interval")}});
        
        $( ".switch-USD-to-CLP" ).keyup(function() {
             var value = $(this).val();
             var type = "UsdToClp";
             //send
             var result = switchChange(value,type);
        });
        
        $( ".switch-CLP-to-USD" ).keyup(function() {
             var value = $(this).val();
            var type = "ClpToUsd";
            //send
           var result = switchChange(value,type);
        });
        
        
        function switchChange(value,type){
            $.ajax({
                beforeSend: function(){
                  // Handle the beforeSend event
                },
                url:"switchusdclp",
                type:"get",
                data : {
                     type: type,
                    value: value
                },
                success : function(result){
                     if( type == "UsdToClp" ){
                         if(result.success) {
                             $(".switch-CLP-to-USD").val(result.result);
                        }
                    } else {
                        if(result.success) {
                            $(".switch-USD-to-CLP").val(result.result); 
                        }
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("some error");
                 },
                complete: function(){
                  
                 }
                 // ......
             });
            
          
        }
        
        // function updateRateBtcUsd(){
        //     $.ajax({
        //         beforeSend: function(){
        //           // Handle the beforeSend event
        //         },
        //         url:"getrateusdbtc",
        //         type:"get",
        //         data : {
                    
        //         },
        //         success : function(result){
        //             console.log(result);
        //             //update
        //             $(".rate-usd-btc").html(result.result.usd + " $");
        //             $(".btc").html( result.result.btc + " BTC");
        //             $(".clp").html(result.result.clp + " CLP");
        //             $(".clpusd").html(result.result.clpusd + " $");
        //             $(".clpbtc").html(result.result.clpbtc + " BTC");
        //         },
        //         error: function(XMLHttpRequest, textStatus, errorThrown) {
        //             //alert("some error");
        //         },
        //         complete: function(){
                  
        //         }
        //         // ......
        //     });
        // }
    </script>
@endsection