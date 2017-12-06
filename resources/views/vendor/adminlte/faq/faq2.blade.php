<!-- Default box -->
@extends('adminlte::layouts.member')

@section('contentheader_title')
    FAQ
@endsection


@section('main-content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">How to buy CLP Mining Package</h3>

        </div>
        <div class="box-body">
            <table class="table" id="myTable" style="top-margin:30px;">
                <tbody>
                <tr data-id="1">
                    <td><h4>1</h4></td>
                    <td style="vertical-align:middle;">Login to your account.</td>
                </tr>
                <tr data-id="2">
                    <td><h4>2</h4></td>
                    <td style="vertical-align:middle;">On dashboard, select CLP Wallet <a href="https://clpcoin.co/wallets/clp"><i class="label label-success">More Info</i></a></td>
                </tr>
                <tr data-id="3">
                    <td><h4>3</h4></td>
                    <td style="vertical-align:middle;">On CLP Wallet, click <a href-"#"><i class="label label-success">Buy Package</i></a>.</td>
                </tr>
                <tr data-id="4">
                    <td><h4>4</h4></td>
                    <td style="vertical-align:middle;">Write down how many CLP and equivalent BTC needed to buy the mining package you want.</td>
                </tr>
                <tr data-id="5">
                    <td><h4>5</h4></td>
                    <td style="vertical-align:middle;">Close the pop up windows. On top of the screen it shows the BTC / CLP rate.</td>
                </tr>
                <tr data-id="6">
                    <td><h4>6</h4></td>
                    <td style="vertical-align:middle;">Go to <a href="https://clpcoin.co/wallets/clp"><i class="label label-info">BTC Wallet</i></a> and deposit the required BTC.  Depending the network traffic, the deposit can take up to 24 hours.</td>
                </tr>
                <tr data-id="7">
                    <td><h4>7</h4></td>
                    <td style="vertical-align:middle;">In <a href="https://clpcoin.co/wallets/clp"><i class="label label-info">BTC Wallet</i></a>, click <a href="https://clpcoin.co/wallets/clp"><i class="label label-success">Buy CLP</i></a>.</td>
                </tr>
                <tr data-id="8">
                    <td><h4>8</h4></td>
                    <td style="vertical-align:middle;">Go to <a href="https://clpcoin.co/wallets/clp"><i class="label label-info">CLP Wallet</i></a>, click <a href="https://clpcoin.co/wallets/clp"><i class="label label-success">Buy Package</i></a> and select the package you want.</td>
                </tr>

                </tbody>
            </table>
        </div>

    </div>
@endsection