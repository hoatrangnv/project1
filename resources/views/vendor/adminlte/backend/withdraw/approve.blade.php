@extends('adminlte::backend.layouts.member')

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
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"> <i
                                    class="glyphicon glyphicon-plus-sign"></i> Create</a>
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
                                    <th>Preview</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($result as $item)
                                    <?php $photo_verification = $item->photo_verification ? json_decode($item->photo_verification, true) : [];?>
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-info scan_photo_view"
                                                    data-image="{{ ($photo_verification && isset($photo_verification['scan_photo']) ? $photo_verification['scan_photo'] : '') }}">
                                                Scan photo
                                            </button>
                                            <button class="btn btn-xs btn-info holding_photo_view"
                                                    data-image="{{ ($photo_verification && isset($photo_verification['holding_photo']) ? $photo_verification['holding_photo'] : '') }}">
                                                Holding photo
                                            </button>
                                        </td>
                                        <td>
                                            {!! Form::open( ['method' => 'post', 'url' => url('users/approve_ok', ['user' => $item->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to OK it?")']) !!}
                                                <button class="btn btn-xs btn-info scan_photo_ok" data-id="{{ $item->id }}">OK</button>
                                            {!! Form::close() !!}
                                            {!! Form::open( ['method' => 'post', 'url' => url('users/approve_cancel', ['user' => $item->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to Cancel it?")']) !!}
                                             <button class="btn btn-xs btn-danger scan_photo_cancel" data-id="{{ $item->id }}">Cancel</button>
                                            {!! Form::close() !!}

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
    <div id="myModalPreview" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-body">
                    <img class="modal-content" id="img01">
                </div>
            </div>
        </div>
    </div>
    <style>
        #myModalPreview img {
            max-width: 100%;
        }
    </style>
    <script>
        $('.holding_photo_view').on('click', function () {
            var modal = $('#myModalPreview');
            $("#img01").attr('src', $(this).data('image'));
            modal.modal('show');
        });
        $('.scan_photo_view').on('click', function () {
            var modal = $('#myModalPreview');
            $("#img01").attr('src', $(this).data('image'));
            modal.modal('show');
        });
    </script>

@endsection