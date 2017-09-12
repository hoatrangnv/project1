@extends('adminlte::layouts.member')

@section('htmlheader_title')
    {{ trans('adminlte_lang::profile.profile') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::profile.my_profile') }}
    <style type="text/css">
        .label-td{
            color: #333;
            font-weight: 700;
        }
        .two-authen .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }

        .two-authen .switch input {display:none;}

        .two-authen .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .two-authen .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .two-authen input:checked + .slider {
          background-color: #2196F3;
        }

        .two-authen input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }

        .two-authen input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }

        /* Rounded sliders */
        .two-authen .slider.round {
          border-radius: 34px;
        }

        .two-authen .slider.round:before {
          border-radius: 50%;
        }
    </style>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('adminlte_lang::profile.personal_data') }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- start -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <tbody>
                                <tr>
                                    <td class="label-td">My id</td>
                                    <td>{{$data['PersonalData']['id']}}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Username</td>
                                    <td>{{$data['PersonalData']['username']}}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Full name</td>
                                    <td>{{$data['PersonalData']['full_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">My email</td>
                                    <td>{{$data['PersonalData']['email']}}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Stress Address</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="label-td">Stress Address 2</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="label-td">City</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="label-td">State</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="label-td">Postal Code</td>
                                    <td></td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Country</td>
                                    <td></td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Phone Number</td>
                                    <td>{{$data['PersonalData']['phone_number']}}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Date of Birth</td>
                                    <td></td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Passport/id card</td>
                                    <td></td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Registration Date</td>
                                    <td>{{$data['PersonalData']['registration_date']}}</td>
                                </tr>
                            </tbody>
                        </table>
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
                        <table class="table no-margin">
                            <tr>
                                <td class="label-td">Scan of photo id</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="label-td">Picture of yourself holding photoid</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('adminlte_lang::profile.sponsor') }}</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                         <table class="table no-margin">
                            <tbody>
                                <tr>
                                    <td class="label-td">Sponsor id</td>
                                    <td>{{$data['PersonalData']['sponsor_id']}}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Sponsor username</td>
                                    <td>{{$data['PersonalData']['sponsor_username']}}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Email</td>
                                    <td>{{$data['PersonalData']['sponsor_email']}}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Phone Number</td>
                                    <td>{{$data['PersonalData']['sponsor_phone_number']}}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Country</td>
                                    <td>{{$data['PersonalData']['sponsor_country']}}</td>
                                </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>
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
                                    <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalChangePassword">Change Password</button></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td> <button type="submit" class="btn btn-primary">Transaction Password</button></td>
                                    <td></td>
                                </tr>
                                <tr >
                                    <td class="label-td">Two - Factor Authentication</td>
                                    <td class="two-authen"> 
                                        <label class="switch">
                                            <input type="checkbox" id="switchAuthen" 
                                            @if($data['PersonalData']['is2fa'])
                                                checked
                                            @else
                                                ''
                                            @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('adminlte_lang::profile.marketing') }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
               <div class="box-body">
                   <div class="table-responsive">
                       <table class="table no-margin">
                            <tr>
                                <td class="label-td">My Refenal link</td>
                                <td></td>
                            </tr> 
                            <tr>
                                <td class="label-td">My Banner</td>
                                <td></td>
                            </tr> 
                            <tr>
                                <td class="label-td">My video</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2"><button type="submit" class="btn btn-primary">Download Crypto Lending Presentation PDF</button></td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2"><button type="submit" class="btn btn-primary">Download Crypto Lending Presentation PPT</button></td>
                            </tr>
                       </table>
                   </div>
               </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- Modal -->
    <div id="myModalChangePassword" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" _lpchecked="1">
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
                          <label for="inputPasswordNew" class="col-sm-4 control-label label-td">New Password</label>

                          <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputPasswordNew" placeholder="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" >
                            <span style="color: red" id="errorNewPassword"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPasswordConfirm" class="col-sm-4 control-label label-td">Confirm Password</label>

                          <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputPasswordConfirm" placeholder="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" >
                            <span style="color: red" id="errorPasswordConfirm"></span>
                          </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="savePassword"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

      </div>
    </div>
    <!-- js -->
    <script type="text/javascript">
        $(function() {
            //action Save Pass
            $( "#savePassword" ).click(function() {
                //compare password and password confirm
                if( $( '#inputPasswordNew' ).val() != $( '#inputPasswordConfirm' ).val() ){
                    $( '#errorPasswordConfirm' ).html("Pasword confirm không giống password mới");
                } else if ( $( '#inputPasswordNew' ).val().trim().length < 6 ) {
                    $( '#errorNewPassword' ).html("Password không được ít hơn 6 ký tự");
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
                            new_password : $( '#inputPasswordNew' ).val()
                        },
                        success : function (result){
                            if(result.success){
                                $(".confirmSuccess").html("Thay đổi thành công")
                            }else{
                                $(".confirmError").html("Có lỗi trong quá trình thay đổi")
                            } 
                        }
                    })
                    .done(function(){
                        $( "#savePassword i" ).removeClass("fa fa-refresh fa-spin");
                        $( "#savePassword i" ).addClass("fa fa-save");
                        $( "#savePassword" ).removeClass("disabled");
                    })
                    .fail(function(xhr, status, error){
                        console.log("Co loi xay ra khi gui send data");
                    });  
                }
            });
            //action switch authen two factor
            $( "#switchAuthen" ).change(function(){
                //send action
                $.ajax({
                    beforeSend : function (){
                        $("#switchAuthen").attr("disabled", true); 
                    },
                    url : "profile/switchauthen",
                    type : "get",
                    success : function (result){
                        console.log(result);
                        if(result.success){
                           alert("update thanh cong");
                        }else{
                           alert("update khong thanh cong");
                        } 
                    }
                })
                .done(function(){
                    $("#switchAuthen").removeAttr("disabled");
                })
                .fail(function(xhr, status, error){
                    console.log("Co loi xay ra khi gui action switch òn off 2 way factor authen");
                });  
            });
        });
    </script>
@endsection