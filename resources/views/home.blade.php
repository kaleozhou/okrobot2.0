@extends('layouts.app')

@section('content')
<style type="text/css">
td{width:100px}
.red{color:red}
.green{color:green}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
<table>
    <tr>
        <td>余额：</td>
        <td class='green'>{{$userinfo['asset_net']}}</td>
        <td>总额：</td>
        <td class='green'>{{$userinfo['asset_total']}}</td>
        <td>可用人民币：</td>
        <td class='green'>{{$userinfo['free_cny']}}</td>
        <td>可用btc：</td>
        <td class='green'>{{$userinfo['free_btc']}}</td>
    </tr>
    <tr>
        <td>最新价格：</td>
        <td class='green'>{{$ticker['last_price']}}</td>
        <td>上次成交价：</td>
        <td class='green'>{{$set['my_last_price']}}</td>
        <td>价值波动：</td>
        <td class='green'>{{$set['n_price']}}</td>
        <td>差价：</td>
        <td class='green'>{{$ticker['dif_price']}}</td>
    </tr>
</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
