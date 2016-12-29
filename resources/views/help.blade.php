@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class='row'>
                        <h3><label class="lead col-xs-5 col-lg-8">OKROBOT使用指南</label></h3>
                    </div>
                    <div class='row'>
                        <h4>问题</h4>
                        <h5>问：注册填写api，secret_key,会不会不安全？</h5>
                        <span>答：不会,因为这里只需要交易权限，资金始终时在你的账户，提不走也转不出去！</span>
                        <h5>问：收不收费</h5>
                        <span>答：暂时不收费，等系统确实可以稳定的帮你赚钱了，到时候也可以适当的按利润的多少资助一点毕竟把OKROBOT做的更好的话还是需要成本的！</span>
                    </div>
                    <div class='row'>
                        <h4>注册</h4>
                        <h5>第一步:在okcoin账户中心申请api</h5>
                        <img class="img-responsive"src="images/help_api.png"/>
                        <h5>第二步:在okcoin账户中心申请api</h5>
                        <img class="img-responsive"src="images/help_register.png"/>
                        <h5>第三步:登录OKROBOT设置成本</h5>
                        <img class="img-responsive"src="images/help_cost.png"/>
                        <h5>第四步:开始运行OKROBOT机器人</h5>
                        <img class="img-responsive"src="images/help_start.png"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center lead font-weight">
    {{config('app.copyright')}}
</div>
</div>
@endsection
