<?php

namespace App\Http\Controllers;
use App\Models\Userinfo;
use App\OKCoin\OKCoin;
use App\OKCoin\ApiKeyAuthentication;
use DB;
use Illuminate\Http\Request;
const API_KEY = "7573fd61-7b8a-4132-814b-9536325c8460";
const SECRET_KEY = "461D47D0FE52B28288E1285D8D899812";
const DOWNLINE=3600;//初始化止损值
const UPLINE=10000;//止盈值
const UPRATE=0.35;//上浮率
const DOWNRATE=0.25;//下浮动率
const UNIT=0.4;//下单单位
const UNITRATE=0.5;//买入，卖出对价值波动的比率
const KLINETYPE="30min";//kline的周期
const SMSUSERNAME="kaleozhou";//短信用户名
const SMSPASSWORD="zh13275747670";//短信密码
const SMSPHONE="13635456575";//短信手机号
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new OKCoin(new ApiKeyAuthentication(API_KEY, SECRET_KEY));
        $params = array('api_key' => API_KEY);
        $result = $client -> userinfoApi($params);
 
        var_dump($result);
//        $users=Userinfo::all();
        //return view('home',['users'=>$result,'phone'=>SMSPHONE]);
    }
}
