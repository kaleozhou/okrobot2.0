@extends('layouts.app')

@section('content')
<style type="text/css">
td{width:90px}
.red{color:red}
.green{color:green}
.wd60{width:60px}
.wd120{width:130px}
</style>
<meta http-equiv="refresh" content="5">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">控制面板</div>
                <div class="panel-body">
<h1>账户信息</h1>
<table>
@if ($userinfo!=null)
    <tr>
        <td>余额：</td>
        <td class='green'>{{$userinfo->asset_net}}</td>
        <td>总额：</td>
        <td class='green'>{{$userinfo->asset_total}}</td>
        <td>可用人民币：</td>
        <td class='green'>{{$userinfo->free_cny}}</td>
        <td>可用btc：</td>
        <td class='green'>{{$userinfo->free_btc}}</td>
    </tr>
@endif
@if ($ticker!=null&&$set!=null)
    <tr>
        <td>最新价格：</td>
        <td class='green'>{{$ticker->last_price}}</td>
        <td>上次成交价：</td>
        <td class='green'>{{$set->my_last_price}}</td>
        <td>价值波动：</td>
        <td class='green'>{{$set->n_price}}</td>
        <td>差价：</td>
        <td class='green'>{{$ticker->dif_price}}</td>
    </tr>
@endif
</table>
<h1>我的订单</h1>
<table>
@if ($orderinfos!=null)
@foreach ($orderinfos as $orderinfo)
    <tr>
        <td>成交价格</td>
        <td>{{$orderinfo->avg_price}}</td>
        <td class='wd60'>成交量</td>
        <td>{{$orderinfo->deal_amount}}</td>
        <td>订单类型</td>
@if ($orderinfo->ordertype=='buy_market') 
        <td class='wd60'>买入</td>
@else
        <td class='wd60'>卖出</td>
@endif
        <td class='wd60'>时间</td>
        <td class='wd120'>{{$orderinfo->create_date}}</td>
    <tr>
@endforeach
</table>
{{$orderinfos->links()}}
<a href='/starttrade'>开始自动交易</a>
<a href='/stoptrade'>停止自动交易</a>
@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
