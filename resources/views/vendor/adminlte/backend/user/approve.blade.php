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
                    <form action="" role="form" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Select Scan Photo</label>
                                    <select class="form-control" name="scan_photo">
                                        <option value="all">Select option</option>
                                        <option value="888888" <?php if(isset($scanPhoto) && $scanPhoto == 888888) { ?> selected <?php } ?> >None</option>
                                        <option value="1" <?php if(isset($scanPhoto) && $scanPhoto == 1) { ?> selected <?php } ?> >Pending</option>
                                        <option value="2" <?php if(isset($scanPhoto) && $scanPhoto == 2) { ?> selected <?php } ?> >Rejected</option>
                                        <option value="3" <?php if(isset($scanPhoto) && $scanPhoto == 3) { ?> selected <?php } ?> >Accpeted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Select Holding Photo</label>
                                    <select class="form-control"  name="holding_photo">
                                        <option value="all">Select option</option>
                                        <option value="4" <?php if(isset($holdingPhoto) && $holdingPhoto == 4) { ?> selected <?php } ?> >None</option>
                                        <option value="5" <?php if(isset($holdingPhoto) && $holdingPhoto == 5) { ?> selected <?php } ?> >Pending</option>
                                        <option value="6" <?php if(isset($holdingPhoto) && $holdingPhoto == 6) { ?> selected <?php } ?> >Rejected</option>
                                        <option value="7" <?php if(isset($holdingPhoto) && $holdingPhoto == 7) { ?> selected <?php } ?> >Accpeted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" >
                                <br>
                                <button type="submit" class="btn btn-success">Filter</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="result-set">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Preview</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($result) > 0)
                                    @foreach($result as $item)
                                        <?php $photo_verification = $item->photo_verification ? json_decode($item->photo_verification, true) : [];?>
                                        <?php $approve = $item->approve ? json_decode($item->approve, true) : [];?>
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
                                                <input type="hidden" value="1" name="type" >
                                                <button class="btn btn-xs btn-info scan_photo_ok" data-id="{{ $item->id }}">Accpet ScanPhoTO</button>
                                                {!! Form::close() !!}
                                                {!! Form::open( ['method' => 'post', 'url' => url('users/approve_ok', ['user' => $item->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to OK it?")']) !!}
                                                <input type="hidden" value="2" name="type" >
                                                <button class="btn btn-xs btn-info scan_photo_ok" data-id="{{ $item->id }}">Accpet HoldingPhoTO</button>
                                                {!! Form::close() !!}
                                                {!! Form::open( ['method' => 'post', 'url' => url('users/approve_ok', ['user' => $item->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to Cancel it?")']) !!}
                                                <input type="hidden" value="3" name="type" >
                                                <button class="btn btn-xs btn-danger scan_photo_cancel" data-id="{{ $item->id }}">Cancel Scanphoto</button>
                                                {!! Form::close() !!}
                                                {!! Form::open( ['method' => 'post', 'url' => url('users/approve_ok', ['user' => $item->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to Cancel it?")']) !!}
                                                <input type="hidden" value="4" name="type" >
                                                <button class="btn btn-xs btn-danger scan_photo_cancel" data-id="{{ $item->id }}">Cancel HoldingPhoTo</button>
                                                {!! Form::close() !!}

                                            </td>
                                            <td>
                                                @if($approve['scan_photo'] == 1)
                                                    <span style="color:orange" >Scan Photo Pending</span> <br>
                                                @endif

                                                @if($approve['scan_photo'] == 2)
                                                    <span style="color:red" >Scan Photo Rejected</span> <br>
                                                @endif

                                                @if($approve['scan_photo'] == 3)
                                                    <span style="color:green" >Scan Photo Accpeted</span> <br>
                                                @endif

                                                @if($approve['holding_photo'] == 5)
                                                        <span style="color:orange" > Holding Photo Pending</span>
                                                @endif

                                                @if($approve['holding_photo'] == 6)
                                                        <span style="color:red" > Holding Photo Rejected</span>
                                                @endif

                                                @if($approve['holding_photo'] == 7)
                                                        <span style="color:green" > Holding Photo Accpeted</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
            $("#img01").attr('src', "{{ url( isset($photo_verification) && isset($photo_verification['holding_photo']) ? $photo_verification['holding_photo'] : '' ) }}");
            modal.modal('show');
        });
        $('.scan_photo_view').on('click', function () {
            var modal = $('#myModalPreview');
            $("#img01").attr('src', "{{ url( isset($photo_verification) && isset($photo_verification['scan_photo']) ? $photo_verification['scan_photo'] : '' ) }}");
            modal.modal('show');
        });
    </script>

@endsection