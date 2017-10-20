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
        @include('adminlte::layouts.wallet')
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
                                            <h4>{{ trans('adminlte_lang::home.total_bonus') }}
                                            </h4>
                                        </td>
                                        <td class="f1-sale">
                                            <b>{{ number_format($data['total_bonus'], 2)}}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">
                                            <h4>{{ trans('adminlte_lang::home.sale_f1') }}
                                            </h4>
                                        </td>
                                        <td class="f1-sale">
                                            <b>{{ number_format($data['newF1InWeek'], 2)}}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">
                                            <h4>{{ trans('adminlte_lang::home.total_sale_f1') }}
                                            </h4>
                                        </td>
                                        <td class="f1-sale">
                                            <b>{{ number_format($data['totalF1Sale'], 2) }}</b>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.f1_vol') }}</td>
                                            <td>{{ number_format($data['f1_left_vol'], 2)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.silver') }}</td>
                                            <td>
                                                {{$data['f1_left_silver_count']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.gold') }}</td>
                                            <td>
                                                {{$data['f1_left_gold_count']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.pear') }}</td>
                                            <td>
                                                {{$data['f1_left_pear_count']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.emerald') }}</td>
                                            <td>
                                                {{$data['f1_left_emerald_count']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.diamond') }}</td>
                                            <td>
                                                {{$data['f1_left_diamond_count']}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered table-hover table-striped award-table">
                                    <tr>
                                        <td class="sale-left">
                                            {{ trans('adminlte_lang::home.f1_left_new') }}
                                        </td>
                                        <td >
                                            <b>{{ number_format($data['leftNew'], 2)}}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sale-left">
                                            {{ trans('adminlte_lang::home.f1_left_tichluy') }}
                                        </td>
                                        <td>
                                            <b>{{ number_format($data['leftTotal'], 2)}}</b>
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
                                            <td class="loyalty">{{ trans('adminlte_lang::home.f1_vol') }}</td>
                                            <td>{{ number_format($data['f1_right_vol'], 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.silver') }}</td>
                                            <td>
                                                {{$data['f1_right_silver_count']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.gold') }}</td>
                                            <td>
                                                {{$data['f1_right_gold_count'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.pear') }}</td>
                                            <td>
                                                {{$data['f1_right_pear_count']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.emerald') }}</td>
                                            <td>
                                                {{$data['f1_right_emerald_count']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="loyalty">{{ trans('adminlte_lang::home.diamond') }}</td>
                                            <td>
                                                {{$data['f1_right_diamond_count']}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered table-hover table-striped award-table">
                                    <tr>
                                        <td class="sale-left">
                                            {{ trans('adminlte_lang::home.f1_right_new') }}
                                        </td>
                                        <td>
                                            <b>{{ number_format($data['rightNew'], 2) }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sale-left">
                                            {{ trans('adminlte_lang::home.f1_right_tichluy') }}
                                        </td>
                                        <td>
                                            <b>{{ number_format($data['rightTotal'], 2)}}</b>
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
                                    <b>{{ Auth::user()->userData->packageDate ? date("Y-m-d", strtotime(Auth::user()->userData->packageDate ."+ 6 months")) : '' }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;">
                                    {{ trans('adminlte_lang::home.withdraw_to_usd') }}
                                </td>
                                <td  class="right">
                                    <button class="btn btn-default bg-olive withdraw-package @if($disabled){{ 'disabled' }} @endif" 
                                            data-id=""
                                            data-toggle="confirmation" data-singleton="true"> {{ trans('adminlte_lang::home.withdraw_to_usd') }}</button>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    @if ($disabled){{ "$('[data-toggle=confirmation]').confirmation('hide');" }}@endif
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
                    if (result.success){
                    $(".usd-amount").html(formatter.format(result.result).replace("$", ""));
                        swal("{{ trans('adminlte_lang::wallet.success')}}");
                    } else{
                        swal(result.message);
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                
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