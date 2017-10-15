@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::profile.profile_refferals') }}
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
                                    <td class="label-td">ID</td>
                                    <td>{{ $user->uid }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Username</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">First Name</td>
                                    <td>{{ $user->firstname }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Last Name</td>
                                    <td>{{ $user->lastname }}</td>
                                </tr>
                                <tr>
                                    <td class="label-td">Email</td>
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
                                    <td>{{ $user->name_country }}</td>
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
                                    <td class="label-td">Passport/ID Card</td>
                                    <td>{{ $user->passport }}</td>
                                </tr> 
                                <tr>
                                    <td class="label-td">Registration Date</td>
                                    <td>{{ $user->created_at->format('Y-m-d')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection