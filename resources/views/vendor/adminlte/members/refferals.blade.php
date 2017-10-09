@extends('adminlte::layouts.member')

@section('contentheader_title')
{{ trans('adminlte_lang::member.refferals') }}
@endsection

@section('main-content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body" style="padding-top:0;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped dataTable">
                        <tr>
                            <th>{{ trans('adminlte_lang::member.refferals_no') }}</th>
                            <th>{{ trans('adminlte_lang::member.refferals_id') }}</th>
                            <th>{{ trans('adminlte_lang::member.refferals_username') }}</th>
                            <th>{{ trans('adminlte_lang::member.refferals_fullname') }}</th>
                            <th>{{ trans('adminlte_lang::member.refferals_package') }}</th>
                            <th>{{ trans('adminlte_lang::member.refferals_more') }}</th>
                            <th>{{ trans('adminlte_lang::member.refferals_loyalty') }}</th>
                        </tr>
                        <tbody>
                            @php
                            $i = 1
                            @endphp
                            @foreach ($users as $userData)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $userData->user->uid }}</td>
                                <td>{{ $userData->user->name }}</td>
                                <td>{{ $userData->user->name }}</td>
                                <td class="text-uppercase">{{ $userData->package->name }}</td>
                                <td>
                                    <a href="{{ URL::to('members/referrals/'.$userData->user->uid.'/detail') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;">{{ trans('adminlte_lang::default.btn_view') }}</a>
                                </td>
                                <td>
                                    @if($userData->loyaltyId >0 )
                                    {{ config('cryptolanding.listLoyalty')[$userData->loyaltyId] }}
                                    @endif
                                    <!--button type="button" class="btn btn-default btn-xs push-into-tree" {{ $userData->isBinary === 1 ? ' disabled' : null }} data-id="{{ $userData->userId }}" data-title="Push into tree" id="btcDeposit"><i class="fa fa-sitemap"></i></button-->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var curID = 0, pushButton = null;
    $(function () {
        $('.push-into-tree').on('click', function () {
            var modal = $('#modal');
            pushButton = $(this);
            curID = pushButton.data('id');
            modal.modal('show');
        });
        $('#submit-command').on('click', function (e) {
            e.preventDefault();
            var pos = $('#push-option').val();
            $.ajax({
                url: "{{ url('members/pushIntoTree') }}/",
                data: {
                    userid: curID,
                    legpos: pos,
                },
                timeout: 15000
            }).done(function (data) {
                $('#modal').modal('hide');
                if (!data.err) {
                    if (pushButton)
                        pushButton.prop('disabled', true);
                    swal({
                        title: "Successfully",
                        text: "User pushed into tree!",
                        type: "success"
                    });
                } else {
                    swal({
                        title: "There's something wrong",
                        text: ErrorCodes[data.err],
                        type: "error"
                    });
                }
            });
        });
    });
</script>
<!--div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title">Push into tree</h3>
                                <small class="font-bold">Please choose leg position.</small>
                        </div>
                        <div class="modal-body">
                                <select class="form-control" id="push-option">
                                        <option value="1">Push into left leg</option>
                                        <option value="2">Push into right leg</option>
                                </select>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary waves-effect" id="submit-command">Push into tree</button>
                        </div>
                </div>
        </div>
</div-->
@endsection