@extends('adminlte::backend.layouts.member')

@section('htmlheader_title')
    Wallet History
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-8">
                    {!! Form::open(['method'=>'GET','url'=>'wallet/history','class'=>'','role'=>'search'])  !!}

                    <div class="input-group custom-search-form pull-right" style="width: 60%">
                        <input type="text" class="form-control" name="q" placeholder="userId...">
                        <span class="input-group-btn">
                            <button class="btn btn-default-sm" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>
                <div class="box-body" style="padding-top:0;">
                    <div class="result-set">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                            <thead>
                            <tr>
                                <th>Created Datetime</th>
                                <th>Updated Datetime</th>
                                <th>Wallet Type</th>
                                <th>Type</th>
                                <th>Note</th>
                                <th>InOut</th>
                                <th>Amount</th>
                                <th>UserId</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $item)
                                <tr>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>{{ $wallet_type[$item->walletType] }}</td>
                                    <td>{{ $bonus_type[$item->type] }}</td>
                                    <td>{{ $item->note }}</td>
                                    <td>{{ $item->inOut }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->userId }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                        <div class="text-center">
                            {{ $result->links() }}
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>

@endsection