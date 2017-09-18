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
    @elseif ( session()->has("successMessage") )
        <div class="callout callout-success">
            <h4>Success!</h4>
            <p>{!! session("successMessage") !!}</p>
        </div>
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
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-footer">
              <div class="row">
                  <div class="col-sm-3 border-right" style="text-align: center">
                      <div class="description-header" style="margin-top: 6px">  
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg>
                    </div>
                  <!-- /.description-block -->
                </div>  
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header">
                        @isset($wallets->currencyPair){{ $wallets->currencyPair->last/10 }}$ @endisset
                    </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header">0.1b /</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3">
                  <div class="description-block">
                    <h5 class="description-header">500CLP</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
        <div class="col-md-5">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header">1 CLP =</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header">0.0000043 BTC =</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3">
                  <div class="description-block">
                    <h5 class="description-header">1000 $</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
        <div class="col-md-2">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user" style="text-align: center">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-footer">
                <button class="btn btn-success" data-toggle="modal" data-target="#modal-default">{{ trans('adminlte_lang::wallet.tranfer_to_clp') }}</button>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                        <!--a href="{{ route('packages.invest') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.buy_package') }}</a-->
                        <!--/<a href="{{ url('wallets/buysellclp') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.buy_clp') }}</a>-->
                </div>
                <div class="box-body" style="padding-top:0;">
                    <table class="table table-bordered table-hover table-striped dataTable">
                        <tr>
                            <th>{{ trans('adminlte_lang::wallet.wallet_no') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_date') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_type') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.amount') }}</th>
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
                                    @if($wallet->type==1)
                                            Buy CLP Coin
                                        @elseif($wallet->type==3)
                                            Bonus Day
                                        @endif
                                </td>
                                <td>{{ $wallet->amount }}</td>
                                <td>
                                    @if($wallet->inOut=='in')
                                    <span class="glyphicon glyphicon-log-in text-primary"></span>
                                    @endif
                                </td>
                                <td>
                                    @if($wallet->inOut=='out')
                                            <span class="glyphicon glyphicon-log-out text-danger"></span>
                                    @endif
                                </td>
                                <td>{{ $wallet->note }}</td> 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        <h4 class="modal-title">{{ trans('adminlte_lang::wallet.tranfer_to_clp') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">USD</label>

                                <div class="col-sm-10">
                                  <input type="number" class="form-control switch-USD-to-CLP" id="inputEmail3" name="usd" placeholder="USD" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">CLP</label>

                                <div class="col-sm-10">
                                  <input type="number" class="form-control switch-CLP-to-USD" id="inputPassword3" name="clp" placeholder="CLP" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
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
    </script>
@endsection