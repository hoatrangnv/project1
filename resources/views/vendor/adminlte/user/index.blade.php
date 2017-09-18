@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::user.header_title') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    @can('add_users')
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Create</a>
                    @endcan
                </div>
                <div class="box-body" style="padding-top:0;">
                    <div class="result-set">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                @can('edit_users', 'delete_users')
                                <th class="text-center">Actions</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->roles->implode('name', ', ') }}</td>
                                    <td>{{ $item->created_at->toFormattedDateString() }}</td>

                                    @can('edit_users')
                                    <td class="text-center">
                                        @include('shared._actions', [
                                            'entity' => 'users',
                                            'id' => $item->id
                                        ])
                                    </td>
                                    @endcan
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