<?php 
use App\User;
$user = User::find($id);
?>
@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::profile.profile_refferals') }}
@endsection

@section('contentheader_description')
    
    <style type="text/css">
        
    </style>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('adminlte_lang::profile.personal_data') }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- start -->
                <div class="box-body">
                    <div class="table-responsive" id="personal_data">
                        <table class="table no-margin">
                            <tbody>
                                <tr>
                                    <td class="label-td">id</td>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Username</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Fisrt name</td>
                                    <td>{{ $user->firstname }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Last name</td>
                                    <td>{{ $user->lastname }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">My email</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Stress Address</td>
                                    <td>{{ $user->address }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Stress Address 2</td>
                                    <td>{{ $user->address2 }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">City</td>
                                    <td>{{ $user->city }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">State</td>
                                    <td>{{ $user->state }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Postal Code</td>
                                    <td>{{ $user->postal_code }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Country</td>
                                    <td>{{ isset($lstCountry[$user->country]) ? $lstCountry[$user->country] : '' }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Phone Number</td>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Date of Birth</td>
                                    <td>{{ $user->birthday }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Passport/id card</td>
                                    <td>{{ $user->passport }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Registration Date</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="personal_data_input" class="hide">
                        {{ Form::model(Auth::user(), array('route' => array('profile.update', $user->id), 'method' => 'PUT')) }}
                        <table class="table no-margin">
                            <tbody>
                            <tr>
                                <td class="label-td">My id</td>
                                <td>{{ $user->uid }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">Username</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">My email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="label-td">Fisrt name</td>
                                <td><input type="text" name="firstname" value="{{ $user->firstname }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">Last name</td>
                                <td><input type="text" name="lastname" value="{{ $user->lastname }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">Stress Address</td>
                                <td><input type="text" name="address" value="{{ $user->address }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">Stress Address 2</td>
                                <td><input type="text" name="address2" value="{{ $user->address2 }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">City</td>
                                <td><input type="text" name="city" value="{{ $user->city }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">State</td>
                                <td><input type="text" name="state" value="{{ $user->state }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">Postal Code</td>
                                <td><input type="text" name="postal_code" value="{{ $user->postal_code }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">Country</td>
                                <td>
                                    <div class="form-group input-group-sm has-feedback{{ $errors->has('country') ? ' has-error' : '' }}">
                                        {{ Form::select('country', $lstCountry, $user->country, ['class' => 'form-control input-sm'], ['placeholder' => 'Choose a country']) }}
                                        @if ($errors->has('country'))
                                            <span class="help-block">
                                                {{ $errors->first('country') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td">Phone Number</td>
                                <td><input type="text" name="phone" value="{{ $user->phone }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">Date of Birth</td>
                                <td><input type="text" name="birthday" value="{{ $user->birthday }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td">Passport/id card</td>
                                <td><input type="text" name="passport" value="{{ $user->passport }}" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="label-td"></td>
                                <td><button type="submit" class="btn btn-info">Save</button></td>
                            </tr>
                            </tbody>
                        </table>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

    
    <!-- js -->
    <script type="text/javascript">
       
    </script>
@endsection