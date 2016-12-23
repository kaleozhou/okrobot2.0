@extends('layouts.app') @section('content')
<script language="JavaScript">
function myrefresh() {
    window.location.reload();

}
setTimeout('myrefresh()', 3000); //指定1秒刷新一次
var ok = 'niahia';

</script>
<!--<meta http-equiv="refresh" content="1">-->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <label class="lead">控制面板</label>
                    <div style="height:50px;width:25%;float:right">
                    <a class="btn btn-success"href='/starttrade'>开始交易</a>
                    <a class="btn btn-danger"href='/stoptrade'>停止交易</a> 
                    </div>
                    <br>
                    @if ($user->autotrade=='1')
                    <div style="font-size:21px;width:30%;float:left">交易状态：<span class="label label-success ">运行中</span></div>
                    @else
                    <div style="font-size:21px;width:30%;float:left">交易状态：<span class="label label-danger ">已停止</span></div>
                    @endif 
                    @if ($profit>0)
                    <div style="font-size:21px;width:30%;float:left">净利润:
                        <span class="label label-success lead">{{round($profit,2)}}%</span></div>
                    @else
                    <div style="font-size:21px;width:30%;float:left">净利润:
                        <span class="label label-warning lead">{{round($profit,2)}}</span></div>
                    @endif
                    @if ($userinfo!=null)
                    <div style="font-size:21px;width:40%;float:left">更新时间:
                    <span>{{$userinfo->updated_at}}</span> 
                    </div>
                    @endif
                    @if ($error!=false)
                    <label>
                        {{$error}}
                    </label> @endif &nbsp;&nbsp;&nbsp;&nbsp; 
                </div>
                <div class="panel-body">
                    <h4>账户信息</h4>
                    <table class="table table-bordered">
                        @if ($userinfo!=null)
                        <tr>
                            <td>余额：</td>
                            <td>{{$userinfo->asset_net-2000}}</td>
                            <td>总额：</td>
                            <td>{{$userinfo->asset_total}}</td>
                            <td>可用资金：</td>
                            <td>{{$userinfo->free_cny}}</td>
                            <td>可用BTC：</td>
                            <td>{{$userinfo->free_btc}}</td>
                        </tr>
                        @endif
                        @if ($ticker!=null&&$set!=null)
                        <tr>
                            <td>价格：</td>
                            <td>{{$ticker->last_price}}</td>
                            <td>上次价格：</td>
                            <td>{{$set->my_last_price}}</td>
                            <td>价值波动：</td>
                            <td>{{$set->n_price}}</td>
                            <td>差价：</td>
                            <td>{{$ticker->dif_price}}</td>
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
                    {{$orderinfos->links()}} 
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
