@extends('adminlte::backend.layouts.member')

@section('htmlheader_title')
    Withdraw
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
                    @can('add_users')
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Create</a>
                    @endcan
                    </div>
                    <div class="col-md-8">
                    {!! Form::open(['method'=>'GET','url'=>'users','class'=>'','role'=>'search'])  !!}

                    <div class="input-group custom-search-form pull-right" style="width: 60%">
                        <input type="text" class="form-control" name="q" placeholder="Search...">
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
                            <table class="table table-responsive table-bordered table-striped table-hover" id="data-table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>UserId</th>
                                <th>WithdrawAmount</th>
                                <!-- <th>WalletAdress</th> -->
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center">Approve</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>@isset($item->users->name){{ $item->users->name }}@endisset</td>
                                    <td>@isset($item->users->email){{ $item->users->email }}@endisset</td>
                                    <td>@isset($item->users->id){{ $item->users->id }}@endisset</td>
                                    <td>{{ $item->withdrawAmount }}</td>
                                    <!-- <td>{{ $item->walletAddress }}</td> -->
                                    <td style="text-transform: uppercase;">{{ $item->type }}</td>
                                    <td>
                                        @if($item->status == 1) 
                                            Success
                                        @elseif($item->status == 3) 
                                            Request
                                        @elseif($item->status == 0 && $item->updated_at > $expiredTime) 
                                            Waiting
                                        @elseif($item->status == 2 || $item->updated_at < $expiredTime) 
                                            Cancel
                                        @endif
                                    </td>
                                    <td>{{ date('Y-m-d H:i:s', strtotime("+6 hours", strtotime($item->created_at))) }}</td>
                                    <td class="text-center">
                                    @if($item->status == 3)
                                        {!! Form::open( ['method' => 'post', 'url' => route('withdraw.approve', ['id' => $item->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure want to approve request ?")']) !!}
                                        <button type="submit" class="btn btn-xs btn-info">
                                            Approve
                                        </button>
                                        {!! Form::close() !!}
                                    @else
                                        &nbsp;
                                    @endif
                                    </td>
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