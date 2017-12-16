@extends('adminlte::layouts.member')

@section('contentheader_title')
    FAQ
@endsection


@section('main-content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">How to activate account</h3>
        </div>
        <div class="box-body">
            <p>Account will be activated automatically when you purchase any of the CLP package. There are 6 CLP packages you available.</p>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <table class="table table-hover table-stripe table-bordered" id="myTable">
                        <thead>
                        <tr id="table_th">
                            <th>Package</th>
                            <th>Price</th>
                            <th>CLP</th>
                            <th>Equivalent BTC</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr data-id="1">
                            <td>TINY</td>
                            <td><i class="fa fa-usd"></i>100</td>
                            <td><span class="icon-clp-icon"></span>66.67</td>
                            <td><span class="fa fa-bitcoin"></span>0.00916846</td>
                        </tr>
                        <tr data-id="2">
                            <td>SMALL</td>
                            <td><i class="fa fa-usd"></i>500</td>
                            <td><span class="icon-clp-icon"></span>333.33</td>
                            <td><span class="fa fa-bitcoin"></span>0.04583954</td>
                        </tr>
                        <tr class="checked" data-id="3">
                            <td>MEDIUM</td>
                            <td><i class="fa fa-usd"></i>1,000</td>
                            <td><span class="icon-clp-icon"></span>666.67</td>
                            <td><span class="fa fa-bitcoin"></span>0.09168046</td>
                        </tr>
                        <tr data-id="4">
                            <td>LARGE</td>
                            <td><i class="fa fa-usd"></i>2,000</td>
                            <td><span class="icon-clp-icon"></span>1,333.33</td>
                            <td><span class="fa fa-bitcoin"></span>0.18335954</td>
                        </tr>
                        <tr data-id="5">
                            <td>HUGE</td>
                            <td><i class="fa fa-usd"></i>5,000</td>
                            <td><span class="icon-clp-icon"></span>3,333.33</td>
                            <td><span class="fa fa-bitcoin"></span>0.04583621</td>
                        </tr>
                        <tr data-id="6">
                            <td>ANGEL</td>
                            <td><i class="fa fa-usd"></i>10,000</td>
                            <td><span class="icon-clp-icon"></span>6,666.67</td>
                            <td><span class="fa fa-bitcoin"></span>0.91673379</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <p>
                Before you buy any CLP package, please check your <a href="https://clpcoin.co/wallets/clp">CLP Wallet</a> to make sure there is sufficient CLP in the wallet.
                If you do not have sufficient CLP, You can go to <a href="https://clpcoin.co/wallets/btc">BTC Wallet</a> and select "Buy CLP".
            </p>
        </div>
    </div>
@endsection