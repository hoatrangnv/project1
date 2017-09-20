@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::wallet.clp') }}
@endsection

@section('main-content')
    <style>
        tr.selected {
            background-color: #5bc0de!important;
        }
        tr.checked {
            background-color: #d9edf7!important;
        }
    </style>
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
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('wallets/buysellclp') }}"
                       class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.sell_clp') }}</a>
                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#buy-package">Buy
                        package</a>
                </div>
                <div class="box-body" style="padding-top:0;">
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
                                <td>{{ $wallet->type }}</td>
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
    <div class="modal fade" id="buy-package" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Investment Package</h4>
                </div>
                {{ Form::open(array('url' => 'packages/invest', 'id'=>'formPackage')) }}
                <div class="modal-body">
                    <div id="msg_package"></div>
                    <table class="table" id="myTable">
                        <tr>
                            <th>{{ trans('adminlte_lang::package.name') }}</th>
                            <th>{{ trans('adminlte_lang::package.price') }}</th>
                        </tr>
                        <tbody>
                        @foreach ($packages as $package)
                            <tr{{ Auth::user()->userData->packageId > 0 && $package->id == Auth::user()->userData->packageId ?  ' class=checked':'' }} data-id="{{ $package->id }}">
                                <td>{{ $package->name }}</td>
                                <td>${{ $package->price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="packageId" id="packageId" value="{{ Auth::user()->userData->packageId }}">
                    <button class="btn btn-success btn-block" id="btn_submit">{{ trans('adminlte_lang::wallet.buy_package') }}</button>
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        var packageId = {{ Auth::user()->userData->packageId }};
        var packageIdPick = packageId;
        $(document).ready(function () {
            $('#myTable tbody').on( 'click', 'tr', function () {
                var _packageId = parseInt($(this).data('id'));
                if(_packageId < packageId) {
                    $('#msg_package').html("<div class='alert alert-danger'>You cant not downgrate package.</div>");
                }else if(_packageId == packageId){
                    $('#msg_package').html("<div class='alert alert-danger'>You purchased this package.</div>");
                }else{
                    $('#myTable tbody tr').removeClass('selected');
                    $(this).addClass('selected');
                    $("#packageId").val(_packageId);
                    packageIdPick = _packageId;
                }
            });
            $('#btn_submit').on('click', function () {
                if(packageIdPick > packageId) {
                    $('#formPackage').submit();
                }else{
                    alert('You cant not this package');
                }
            });
        });
    </script>
@endsection