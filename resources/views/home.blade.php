@extends('layouts.app') @section('content')
<!--<meta http-equiv="refresh" content="1">-->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class='row'>
                        <label class="lead col-xs-5 col-md-8">控制面板</label>
                        <label class="lead col-xs-6 col-md-4">正在运行策略{{config('okcoin.tradetype')}}</label>
                    @if ($userinfo!=null)
                        @if ($user->cost>0)
                        <label id='cost' class="lead col-xs-6 col-md-4">成本：{{$user->cost}}</label>
                        @else
                        <label id='cost' class="col-xs-6 col-md-4 label-danger">请设置成本</label>
                        @endif
                        @if (($userinfo->asset_total-$user->cost)>0)
                        <label id='zhuanle' class="lead col-xs-6 col-md-4 label-success">盈利：{{round(($userinfo->asset_total-$user->cost),2)}}</label>
                        @else
                        <label id='zhuanle' class="lead col-xs-6 col-md-4 label-warning">盈利：{{round(($userinfo->asset_total-$user->cost),2)}}</label>
                        @endif
                        @endif
                    </div>
                    @if ($userinfo!=null)
                    <div class='row'>
                        @if ($profit>0)
                        <div class='col-xs-4 col-md-2'>
                            利润:
                            <span id ="profit"class="label label-success lead">{{round($profit,2)}}%</span></div>
                        @else
                        <div class='col-xs-4 col-md-2'>
                            利润:
                            <span  id ="profit"class="label label-warning lead">{{round($profit,2)}}%</span></div>
                        @endif
                        <div class='col-xs-8 col-md-4'>
                            更新:
                            <span id='updated_at'>{{$userinfo->updated_at}}</span> 
                        </div>
                        @if ($user->btc_autotrade=='1')
                        <div class='col-xs-6 col-md-3'>
                            BTC状态:<span  id ="btc_autotrade"class="label label-success ">BTC运行中</span>
                            <a  id ="btc_autotrade_btn"class="btn btn-danger btn-mini"href='/stoptrade/btc_cny'>BTC停止</a> 
                        </div>
                        @else
                        <div class='col-xs-6 col-md-3'>
                            BTC状态:<span id ="btc_autotrade"class="label label-danger ">BTC已停止</span>
                            <a  id ="btc_autotrade_btn"class="btn btn-success btn-mini"href='/starttrade/btc_cny'>BTC开始</a>
                        </div>
                        @endif 
                        @if ($user->ltc_autotrade=='1')
                        <div class='col-xs-6 col-md-3'>
                            LTC状态:<span id ="ltc_autotrade"class="label label-success ">LTC运行中</span>
                            <a  id ="ltc_autotrade_btn"class="btn btn-danger btn-mini"href='/stoptrade/ltc_cny'>LTC停止</a> 
                        </div>
                        @else
                        <div class='col-xs-6 col-md-3'>
                            LTC状态:<span id ="ltc_autotrade"class="label label-danger ">LTC已停止</span>
                            <a  id ="ltc_autotrade_btn"class="btn btn-success btn-mini"href='/starttrade/ltc_cny'>LTC开始</a>
                        </div>
                        @endif 
                        @if ($error!=false)
                        <div class='col-xs-12'>
                            <label>
                                {{$error}}
                            </label> @endif &nbsp;&nbsp;&nbsp;&nbsp; 
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <h4>账户信息</h4>
                    @if ($userinfo!=null)
                    <div class='row'>
                        <span class='col-xs-3 col-md-2'>净资产:</span>
                        <span  id ="asset_net" class='col-xs-3 col-md-2 numeric'>{{$userinfo->asset_net}}</span>
                        <span class='col-xs-3 col-md-2'>BTC:</span>
                        <span  id ="free_btc"class='col-xs-3 col-md-2'>{{$userinfo->free_btc}}</span>
                        <span class='col-xs-3 col-md-2'>LTC:</span>
                        <span  id ="free_ltc"class='col-xs-3 col-md-2'>{{$userinfo->free_ltc}}</span>
                        <span class='col-xs-3 col-md-2'>总额:</span>
                        <span  id ="asset_total"class='col-xs-3 col-md-2'>{{$userinfo->asset_total}}</span>
                        <span class='col-xs-6 col-md-2 text-warning'>可用:</span>
                        <span  id ="free_cny"class='col-xs-6 col-md-2 text-warning'>{{$userinfo->free_cny}}</span>
                    </div>
                    @endif
                    @if ($btc_ticker!=null&&$set!=null&&$user->btc_autotrade=='1')
                    <h4>行情信息</h4>
                    <div class='row'>
                        <span class='col-xs-3 col-md-2'>BTC:</span>
                        <span  id ="btc_last_price"class='col-xs-3 col-md-2'>{{$btc_ticker->last_price}}</span>
                        <span class='col-xs-3 col-md-2'>前价:</span>
                        <span  id ="btc_my_last_price"class='col-xs-3 col-md-2'>{{$set->btc_my_last_price}}</span>
                        <span class='col-xs-3 col-md-2'>波动:</span>
                        <span  id ="btc_n_price"class='col-xs-3 col-md-2'>{{$set->btc_n_price}}</span>
                        <span class='col-xs-3 col-md-2'>差价:</span>
                        <span  id ="btc_dif"class='col-xs-3 col-md-2'>{{round($btc_ticker->last_price-$set->btc_my_last_price,3)}}</span>
                        <span  class='col-xs-3 col-md-2 text-success'>上偏差:</span>
                        <span  id ="btc_up_dif"class='col-xs-3 col-md-2 text-success '>{{$set->btc_n_price*$set->uprate}}</span>
                        <span  class='col-xs-3 col-md-2 text-danger'>下偏差:</span>
                        <span  id ="btc_down_dif"class='col-xs-3 col-md-2 text-danger '>{{$set->btc_n_price*$set->downrate}}</span>
                    </div>
                    @endif
                    @if ($ltc_ticker!=null&&$set!=null&&$user->ltc_autotrade=='1')
                    <h4>行情信息</h4>
                    <div class='row'>
                        <span class='col-xs-3 col-md-2'>LTC:</span>
                        <span id ="ltc_last_price"class='col-xs-3 col-md-2'>{{$ltc_ticker->last_price}}</span>
                        <span class='col-xs-3 col-md-2'>前价:</span>
                        <span  id ="ltc_my_last_price"class='col-xs-3 col-md-2'>{{$set->ltc_my_last_price}}</span>
                        <span class='col-xs-3 col-md-2'>波动:</span>
                        <span  id ="ltc_n_price"class='col-xs-3 col-md-2'>{{$set->ltc_n_price}}</span>
                        <span class='col-xs-3 col-md-2'>差价:</span>
                        <span  id ="ltc_dif"class='col-xs-3 col-md-2'>{{round($ltc_ticker->last_price-$set->ltc_my_last_price,2)}}</span>
                        <span class='col-xs-6 col-md-2 text-success'>上偏差:</span>
                        <span  id ="ltc_up_dif"class='col-xs-6 col-md-2 text-success'>{{$set->ltc_n_price*$set->uprate}}</span>
                        <span class='col-xs-3 col-md-2 text-danger'>下偏差:</span>
                        <span  id ="ltc_down_dif"class='col-xs-3 col-md-2 text-danger '>{{$set->ltc_n_price*$set->downrate}}</span>
                    </div>
                    @endif
                    <h4>我的订单</h4>
                    <table id="ddtable"class="table table-bordered table-container ">
                        <tr>
                            <td class='lead'>价格</td>
                            <td class='lead'>数量</td>
                            <td class='lead'>类型</td>
                            <td class='lead'>类型</td>
                            <td class='lead'>时间</td>
                        </tr>
                        @if ($orderinfos!=null)
                        <tr>
                            @foreach ($orderinfos as $orderinfo)
                            <td>{{$orderinfo->avg_price}}</td>
                            <td>{{$orderinfo->deal_amount}}</td>
                            <td>{{$orderinfo->symbol}}</td>
                            @if ($orderinfo->ordertype=='buy_market')
                            <td>买入</td>
                            @else
                            <td>卖出</td>
                            @endif
                            <td>{{$orderinfo->create_date}}</td>
                        </tr>
                        @endforeach
                        </div>
                    </table>
                    @endif
                </div>
            </div>
                @else
                <h5><label class="label label-danger">你的apy_key设置不正确,请修改个人信息！</label></h5>
                @endif
        </div>
    </div>
    <script type="text/javascript" src="js/home.js"></script>
    <div class="text-center lead font-weight">
        {{config('app.copyright')}}
    </div>
</div>
@endsection
