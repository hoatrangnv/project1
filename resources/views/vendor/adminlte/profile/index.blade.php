@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::profile.my_profile') }}
@endsection

@section('main-content')
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
    <div class="row">
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('adminlte_lang::profile.personal_data') }}</h3>
                    <button class="btn btn-xs btn-info pull-right" id="personal_data_btn">Edit</button>
                </div>
                <!-- /.box-header -->
                <!-- start -->
                <div class="box-body">
                    <div class="table-responsive" id="personal_data">
                        <table class="table no-margin">
                            <tbody>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.my_id') }}</td>
                                    <td>{{ Auth::user()->uid }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.username') }}</td>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.first_name') }}</td>
                                    <td>{{ Auth::user()->firstname }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.last_name') }}</td>
                                    <td>{{ Auth::user()->lastname }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.my_email') }}</td>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.street_address_1') }}</td>
                                    <td>{{ Auth::user()->address }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.street_address_2') }}</td>
                                    <td>{{ Auth::user()->address2 }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.city') }}</td>
                                    <td>{{ Auth::user()->city }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.state') }}</td>
                                    <td>{{ Auth::user()->state }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.postal_code') }}</td>
                                    <td>{{ Auth::user()->postal_code }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.country') }}</td>
                                    <td>{{ Auth::user()->name_country }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.phone') }}</td>
                                    <td>{{ Auth::user()->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.birthday') }}</td>
                                    <td>{{ Auth::user()->birthday }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.passport') }}</td>
                                    <td>{{ Auth::user()->passport }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.created_at') }}</td>
                                    <td>{{ Auth::user()->created_at->format('Y-m-d') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="personal_data_input" class="hide">
                        {{ Form::model(Auth::user(), array('route' => array('profile.update', Auth::user()->id), 'method' => 'PUT')) }}
                        <table class="table no-margin">
                            <tbody>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.my_id') }}</td>
                                <td>{{ Auth::user()->uid }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.username') }}</td>
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.my_email') }}</td>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.first_name') }}</td>
                                <td>{{ Auth::user()->firstname }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.last_name') }}</td>
                                <td>{{ Auth::user()->lastname }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.street_address_1') }}</td>
                                <td><input type="text" name="address" value="{{ Auth::user()->address }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.street_address_2') }}</td>
                                <td><input type="text" name="address2" value="{{ Auth::user()->address2 }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.city') }}</td>
                                <td><input type="text" name="city" value="{{ Auth::user()->city }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.state') }}</td>
                                <td><input type="text" name="state" value="{{ Auth::user()->state }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.postal_code') }}</td>
                                <td><input type="text" name="postal_code" value="{{ Auth::user()->postal_code }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.country') }}</td>
                                <td>{{ Auth::user()->name_country }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.phone') }}</td>
                                <td><input type="text" name="phone" value="{{ Auth::user()->phone }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.birthday') }}</td>
                                @if(Auth::user()->birthday)
                                    <td>{{Auth::user()->birthday}}</td>
                                @else
                                    <td><input type="date" name="birthday" value="{{ Auth::user()->birthday }}" class="form-control input-sm"></td>
                                @endif
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.passport') }}</td>
                                @if(Auth::user()->passport)
                                    <td>{{Auth::user()->passport}}</td>
                                @else
                                    <td><input type="text" name="passport" value="{{ Auth::user()->passport }}" class="form-control input-sm"></td>
                                @endif
                            </tr>
                            <tr>
                                <td class="label-td"></td>
                                <td><button type="submit" class="btn btn-info">{{ trans('adminlte_lang::profile.btn_save') }}</button></td>
                            </tr>
                            </tbody>
                        </table>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('adminlte_lang::profile.verification') }}</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <p class="" id="photo_msg"></p>
                        <?php $photo_verification = Auth::user()->photo_verification ? json_decode(Auth::user()->photo_verification, true) : [];?>
                        <table class="table no-margin">
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.scan_photo') }}</td>
                                <!-- <td>
                                    <button id="scan_photo_view" class="btn btn-xs btn-info">Preview</button>
                                    <input type="file" name="scan_photo" id="scan_photo" accept="image/*" />
                                    <input type="hidden" value="{{ ($photo_verification && isset($photo_verification['scan_photo']) ? $photo_verification['scan_photo'] : '') }}" id="scan_photo_thumb"/>
                                </td> -->
                            </tr>
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.holding_photo') }}</td>
                                <!-- <td>
                                    <button id="holding_photo_view" class="btn btn-xs btn-info">Preview</button>
                                    <input type="file" name="holding_photo" id="holding_photo" accept="image/*" />
                                    <input type="hidden" value="{{ ($photo_verification && isset($photo_verification['holding_photo']) ? $photo_verification['holding_photo'] : '') }}" id="holding_photo_thumb"/>
                                </td> -->
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @if(isset($sponsor))
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('adminlte_lang::profile.sponsor') }}</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                         <table class="table no-margin">
                            <tbody>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.sponsor_id') }}</td>
                                    <td>{{ $sponsor->uid }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.sponsor_username') }}</td>
                                    <td>{{ $sponsor->name }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.my_email') }}</td>
                                    <td>{{ $sponsor->email }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">{{ trans('adminlte_lang::profile.country') }}</td>
                                    <td>{{ $sponsor->name_country }}</td>
                                </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>
            @endif
            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('adminlte_lang::profile.marketing') }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
               <div class="box-body">
                   <div class="table-responsive">
                       <table class="table no-margin" style="width: 98%">
                            <tr>
                                <td class="label-td">{{ trans('adminlte_lang::profile.my_referal_link') }}</td>
                                <td>
                                <div class="row">
                                <div class="col-lg-12">
                                <div class="input-group input-group-sm">
                                <input type="text" name="ref" id="ref_link" value="{{ route('user.ref', Auth::user()->name) }}" class="form-control" readonly="true">
                                <!-- <button class="btn_ref_link cp-btc" data-clipboard-target="#ref_link" title="copy">
                                                <i class="fa fa-clone"></i> -->
                                        <span class="input-group-btn">
        <button class="btn btn-default btn_ref_link" data-clipboard-target="#ref_link"><i class="fa fa-clone"></i></button>
      </span>
                                            <!-- </button> -->
                                            </div>
                                </div>
                                </div>
                                </td>
                            </tr> 
                       </table>
                   </div>
               </div>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('adminlte_lang::profile.security_settings') }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <tbody>
                                <tr>
                                    <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalChangePassword">{{ trans('adminlte_lang::profile.change_password') }}</button></td>
                                    <td></td>
                                </tr>
                                <tr >
                                    <td class="label-td">{{ trans('adminlte_lang::profile.two_factor_authen') }}</td>
                                    <td class="two-authen"> 
                                        <label class="switch">
                                            <input type="checkbox" id="switchAuthen" {{ Auth::user()->is2fa ? 'checked' : '' }}>
                                        </label>
                                    </td>
                                </tr>
                                <tr id="2fa-google-barcode">
                                    <td colspan="2">
                                        <div class="qrcode">
                                            @if(!Auth::user()->is2fa)
                                                <img src="{{ $google2faUrl }}">
                                            @else
                                                <img src="">
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Modal -->
    <div id="myModalChangePassword" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('adminlte_lang::profile.change_password') }}</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formchangpassword" _lpchecked="1">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <div class="confirmSuccess" style="color:green">

                                    </div>
                                    <div class="confirmError" style="color:red">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPasswordOld" class="col-sm-4 control-label label-td">{{ trans("adminlte_lang::profile.old_password") }}</label>

                                <div class="col-sm-8">
                                  <input type="password" class="form-control" id="inputPasswordOld" placeholder="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" >
                                  <span style="color: red" id="errorOldPassword"></span>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="inputPasswordNew" class="col-sm-4 control-label label-td">{{ trans("adminlte_lang::profile.new_password") }}</label>

                              <div class="col-sm-8">
                                <input type="password" class="form-control" id="inputPasswordNew" placeholder="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" >
                                <span style="color: red" id="errorNewPassword"></span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="inputPasswordConfirm" class="col-sm-4 control-label label-td">{{ trans("adminlte_lang::profile.confirm_password") }}</label>

                              <div class="col-sm-8">
                                <input type="password" class="form-control" id="inputPasswordConfirm" placeholder="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" >
                                <span style="color: red" id="errorPasswordConfirm"></span>
                              </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="savePassword"><i class="fa fa-save"></i> {{ trans('adminlte_lang::profile.btn_save') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('adminlte_lang::profile.btn_close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModalOff2FA" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">2FA</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <div class="confirmSuccess" style="color:green"></div>
                                    <div class="confirmError" style="color:red"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPasswordNew" class="col-sm-4 control-label label-td">2FA Code</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="codeOtp" placeholder="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="myModalOff2FA_check"><i class="fa fa-save"></i> {{ trans('adminlte_lang::profile.btn_save') }}</button>
                    <button type="button" class="btn btn-default" id="myModalOff2FA_close">{{ trans('adminlte_lang::profile.btn_close') }}</button>
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
        #myModalPreview img {max-width: 100%;}
    </style>
    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
    <link href="/bootstrap-switch/bootstrap-switch.css" rel="stylesheet">
    <script src="/bootstrap-switch/bootstrap-switch.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.btn_ref_link').tooltip({
                trigger: 'click',
                placement: 'left'
            });
            
            function setTooltip(message) {
                $('.btn_ref_link')
                  .attr('data-original-title', message)
                  .tooltip('show');
            }
            
            function hideTooltip() {
                setTimeout(function() {
                  $('button').tooltip('hide');
                }, 1000);
              }
            
            var clipboard = new Clipboard('.btn_ref_link');
            clipboard.on('success', function(e) {
                e.clearSelection();
                setTooltip('Copied!');
                hideTooltip();
            });

            $( '#inputPasswordNew' ).focus(function(){
                $( '#errorNewPassword' ).hide();
            });
            $( '#inputPasswordConfirm' ).focus(function(){
                $( '#errorPasswordConfirm' ).hide();
            });
            $( '#inputPasswordOld' ).focus(function(){
                $( '#errorOldPassword' ).hide();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#scan_photo_view').on('click', function () {
                var modal = $('#myModalPreview');
                $("#img01").attr('src',$('#scan_photo_thumb').val());
                modal.modal('show');
            });
            $('#scan_photo').on('change', function () {
                //$(this).val("");
                if ($(this).val() != '') {
                    var file_data = $('#scan_photo').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    form_data.append('type', 'scan_photo');
                    $.ajax({
                        url: '/profile/upload',
                        data: form_data,
                        dataType: 'json',
                        async: false,
                        type: 'post',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if(!response.err){
                                $('#scan_photo_thumb').val(response.image);
                                $('#photo_msg').text('Upload successfully.');
                            }else{
                                alert(response.msg);
                            }
                        },
                    });
                }
                $(this).val("");
            });
            $('#holding_photo_view').on('click', function () {
                var modal = $('#myModalPreview');
                $("#img01").attr('src',$('#holding_photo_thumb').val());
                modal.modal('show');
            });
            $('#holding_photo').on('change', function () {
                //$(this).val("");
                if ($(this).val() != '') {
                    var file_data = $('#holding_photo').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    form_data.append('type', 'holding_photo');
                    $.ajax({
                        url: '/profile/upload',
                        data: form_data,
                        dataType: 'json',
                        async: false,
                        type: 'post',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if(!response.err){
                                $('#holding_photo_thumb').val(response.image);
                                $('#photo_msg').text('Upload successfully.');
                            }else{
                                alert(response.msg);
                            }
                        },
                    });
                }
                $(this).val("");
            });


            //action Save Pass
            $( "#savePassword" ).click(function() {
                //compare password and password confirm
                if ( $( '#inputPasswordNew' ).val().trim().length < 6 ) {
                    $( '#errorNewPassword' ).show();
                    $( '#errorNewPassword' ).html("{{ trans('adminlte_lang::profile.minimum_password') }}");
                } else if( $( '#inputPasswordNew' ).val() != $( '#inputPasswordConfirm' ).val() ){
                    $( '#errorPasswordConfirm' ).show();
                    $( '#errorPasswordConfirm' ).html("{{ trans('adminlte_lang::profile.password_not_match') }}");
                } else {
                    //send password 
                    $.ajax({
                        beforeSend : function (){
                            $( "#savePassword i" ).removeClass("fa fa-save");
                            $( "#savePassword i" ).addClass("fa fa-refresh fa-spin");
                            $( "#savePassword" ).addClass("disabled");
                        },
                        url : "profile/changepassword",
                        type : "post",
                        data : {
                            _token:  $("meta[name='csrf-token']").attr("content"), 
                            new_password : $( '#inputPasswordNew' ).val(),
                            old_password : $( '#inputPasswordOld ').val(),
                            confirm_password: $( '#inputPasswordConfirm ').val()
                        },
                        success : function (result){
                            console.log(result.errorcode);
                            if(result.errorcode == 1){
                                $( '#errorOldPassword' ).show();
                                $( '#errorOldPassword' ).html("{{ trans('adminlte_lang::profile.wrong_password') }}");
                            } else if (result.success){
                                $('#myModalChangePassword').modal('hide');
                                alert("{{ trans('adminlte_lang::profile.success') }}");
                            } else {
                                $('#myModalChangePassword').modal('hide');
                                alert("{{ trans('adminlte_lang::profile.fail') }}");
                            } 


                        }
                    })
                    .done(function(){
                        $( "#savePassword i" ).removeClass("fa fa-refresh fa-spin");
                        $( "#savePassword i" ).addClass("fa fa-save");
                        $( "#savePassword" ).removeClass("disabled");
                        $("#formchangpassword")[0].reset();
                    })
                    .fail(function(xhr, status, error){
                        console.log("{{ trans('adminlte_lang::profile.error') }}");
                    });  
                }
            });

            $('#switchAuthen').bootstrapSwitch({
                size: 'mini',
                onSwitchChange: function (event, state) 
                {

                    var modal = $('#myModalOff2FA');
                    modal.modal({backdrop: 'static'})
                    modal.modal('show');
                    if( !$("#switchAuthen").is(':checked') )
                    {//if on -> off
                        $('#myModalOff2FA_check').click(function () {
                            var codeOtp = $.trim($('#codeOtp').val());
                            if( codeOtp !=''){
                                $.ajax({
                                    url : "profile/switchauthen",
                                    data: {codeOtp: codeOtp, status:1},
                                    type : "get",
                                    success : function (result){
                                        if(result.success){
                                            //$('#switchAuthen').bootstrapSwitch('state', !state, true);
                                            modal.modal('hide');
                                            $('#switchAuthen').bootstrapSwitch('state', false, false);
                                            $("#switchAuthen").attr('checked', false);
                                            location.href = '{{ url()->current() }}';
                                        }else{
                                            modal.find('.confirmError').text(result.msg);
                                        }
                                    }
                                });
                            }else{
                                alert('Please input 2FA code.');
                            }
                        });

                        $('#myModalOff2FA_close').click(function () {
                            $('#switchAuthen').bootstrapSwitch('state', !state, true);
                            $('#codeOtp').val('');
                            modal.find('.confirmError').text('');
                            modal.modal('hide');
                        });
                    }
                    else
                    {//if off -> on
                        $('#myModalOff2FA_check').click(function () {
                            var codeOtp = $.trim($('#codeOtp').val());
                            if( codeOtp !=''){
                                $.ajax({
                                    url : "profile/switchauthen",
                                    data: {codeOtp: codeOtp, status:0},
                                    type : "get",
                                    success : function (result){
                                        if(result.success){
                                            modal.modal('hide');
                                            $('#switchAuthen').bootstrapSwitch('state', true, true);
                                            $("#switchAuthen").attr('checked', true);
                                            location.href = '{{ url()->current() }}';
                                        }else{
                                            modal.find('.confirmError').text(result.msg);
                                        }
                                    }
                                });
                            }else{
                                alert('Please input 2FA Code.');
                            }
                        });

                        $('#myModalOff2FA_close').click(function () {
                            $('#switchAuthen').bootstrapSwitch('state', !state, true);
                            $('#codeOtp').val('');
                            modal.find('.confirmError').text('');
                            modal.modal('hide');
                        });
                    }
                }
            });

            $('#personal_data_btn').click(function () {
                $('#personal_data').hide();
                $('#personal_data_input').removeClass('hide');
            });
        });
    </script>
@endsection