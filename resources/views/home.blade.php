@extends('layouts.app') @section('content')
<script language="JavaScript">
function myrefresh() {
    window.location.reload();

}
setTimeout('myrefresh()', 5000); //指定1秒刷新一次

</script>
<!--<meta http-equiv="refresh" content="1">-->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class='row'>
                    <label class="lead col-xs-4">控制面板</label>
                    </div>
                    <div class='row'>
                    @if ($profit>0)
                    <div class='col-xs-4'>
                        利润:
                        <span class="label label-success lead">{{round($profit,2)}}%</span></div>
                    @else
                    <div class='col-xs-4'>
                        利润:
                        <span class="label label-warning lead">{{round($profit,2)}}</span></div>
                    @endif
                    <div class='col-xs-8'>
                    更新:
                    <span>{{$userinfo->updated_at}}</span> 
                    </div>
                </div>
                    @if ($userinfo!=null)
                    <div class='row'>
                    @if ($user->btc_autotrade=='1')
                    <div class='col-xs-6'>
                    BTC状态：<span class="label label-success ">BTC运行中</span></div>
                    @else
                    <div class='col-xs-6'>
                    BTC状态：<span class="label label-danger ">BTC已停止</span></div>
                    @endif 
                    @if ($user->ltc_autotrade=='1')
                    <div class='col-xs-6'>
                    LTC状态：<span class="label label-success ">LTC运行中</span></div>
                    @else
                    <div class='col-xs-6'>
                    LTC状态：<span class="label label-danger ">LTC已停止</span></div>
                    @endif 
                    </div>
                    @endif
                    <div class='row'>
                    <div class='col-xs-6'>
                    <a class="btn btn-success"href='/starttrade/btc_cny'>BTC开始</a>
                    <a class="btn btn-danger"href='/stoptrade/btc_cny'>BTC停止</a> 
                    </div>
                    <div class='col-xs-6'>
                    <a class="btn btn-success"href='/starttrade/ltc_cny'>LTC开始</a>
                    <a class="btn btn-danger"href='/stoptrade/ltc_cny'>LTC停止</a> 
                    </div>
                    </div>
                    @if ($error!=false)
                    <div class='row'>
                    <div class='col-xs-12'>
                    <label>
                        {{$error}}
                    </label> @endif &nbsp;&nbsp;&nbsp;&nbsp; 
                    </div>
                    </div>
                    </div>
                <div class="panel-body">
                    <h4>账户信息</h4>
                    <table class="table table-bordered">
                        @if ($userinfo!=null)
                        <tr class='row'>
                            <td class='col-xs-3'>余额：</td>
                            <td class='col-xs-3'>{{$userinfo->asset_net}}</td>
                            <td class='col-xs-3'>总额：</td>
                            <td class='col-xs-3'>{{$userinfo->asset_total}}</td>
                        </tr>
                        <tr class='row'>
                            <td class='col-xs-2'>可用BTC：</td>
                            <td class='col-xs-2'>{{$userinfo->free_btc}}</td>
                            <td class='col-xs-2'>可用LTC：</td>
                            <td class='col-xs-2'>{{$userinfo->free_ltc}}</td>
                        </tr>
                        <tr class='row'>
                            <td class='col-xs-2'>可用资金：</td>
                            <td class='col-xs-10'>{{$userinfo->free_cny}}</td>
                        </tr>
                        @endif
                        @if ($btc_ticker!=null&&$set!=null)
                        <tr class='row'>
                            <td class='col-xs-3'>BTC价格：</td>
                            <td class='col-xs-3'>{{$btc_ticker->last_price}}</td>
                            <td class='col-xs-3'>上次价格：</td>
                            <td class='col-xs-3'>{{$set->btc_my_last_price}}</td>
                        </tr>
                        <tr class='row'>
                            <td class='col-xs-2'>价值波动：</td>
                            <td class='col-xs-2'>{{$set->btc_n_price}}</td>
                            <td class='col-xs-2'>差价：</td>
                            <td class='col-xs-2'>{{round($btc_ticker->last_price-$set->btc_my_last_price,2)}}</td>
                        </tr>
                        <tr class='row'>
                            <td class='col-xs-2'>偏差：</td>
                            <td class='col-xs-2'>{{$set->btc_n_price*$set->uprate}}</td>
                        </tr>
                        @endif
                        @if ($ltc_ticker!=null&&$set!=null)
                        <tr class='row'>
                            <td class='col-xs-3'>LTC价格：</td>
                            <td class='col-xs-3'>{{$ltc_ticker->last_price}}</td>
                            <td class='col-xs-3'>上次价格：</td>
                            <td class='col-xs-3'>{{$set->ltc_my_last_price}}</td>
                        </tr>
                        <tr class='row'>
                            <td class='col-xs-2'>价值波动：</td>
                            <td class='col-xs-2'>{{$set->ltc_n_price}}</td>
                            <td class='col-xs-2'>差价：</td>
                            <td class='col-xs-2'>{{round($ltc_ticker->last_price-$set->ltc_my_last_price,2)}}</td>
                        </tr>
                        <tr class='row'>
                            <td class='col-xs-2'>偏差：</td>
                            <td class='col-xs-2'>{{$set->ltc_n_price*$set->uprate}}</td>
                        </tr>
                        @endif
                    </table>
                    <h4>我的订单</h4>
                    <table class="table table-bordered">
                    @if ($orderinfos!=null)
                    @foreach ($orderinfos as $orderinfo)
                        <tr>
                            <td>成交价格</td>
                            <td>{{$orderinfo->avg_price}}</td>
                            <td>成交量</td>
                            <td>{{$orderinfo->deal_amount}}</td>
                            <td>类型</td>
                            <td>{{$orderinfo->symbol}}</td>
                            <td>订单类型</td>
                            @if ($orderinfo->ordertype=='buy_market')
                            <td>买入</td>
                            @else
                            <td>卖出</td>
                            @endif
                            <td>时间</td>
                            <td>{{$orderinfo->create_date}}</td>
                            <tr>
                                @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
