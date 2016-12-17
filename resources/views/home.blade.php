@extends('layouts.app')

@section('content')
<style type="text/css">
td{width:90px}
.red{color:red}
.green{color:green}
.wd60{width:60px}
.wd120{width:130px}
label{}
.red{color:red}
.green{color:green}
</style>
<meta http-equiv="refresh" content="5">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                          <label>控制面板</label><br>
                    <label> 交易状态：</label>
                    @if ($user->autotrade=='1')
                    <label class='green'>运行中</label>
                    @else
                    <label class='red'>已停止</label>
                    @endif
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href='/starttrade'>开始交易</a>
                    <a href='/stoptrade'>停止交易</a>
                    @if ($error!=false)
                    <label class='red'>
                    {{$error}}
                    </label>
                    @endif
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    @if ($userinfo!=null)
                    <label>更新时间</label>
                    <label>{{$userinfo->updated_at}}</label>
                    @endif
                </div>
                <div class="panel-body">
<h4>账户信息</h4>
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
<h4>我的订单</h4>
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
@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
