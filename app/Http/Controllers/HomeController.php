<?php

namespace App\Http\Controllers;
use App\Models\Userinfo;
use App\OKCoin\OKCoin;
use App\OKCoin\ApiKeyAuthentication;
use App\Libraries\OKTOOL;
use DB;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        //读取配置文件的key
        $api_key=config('okcoin.api_key');
        $secret_key=config('okcoin.secret_key');
        $client =new OKCoin(new ApikeyAuthentication($api_key,$secret_key));
        $OKTOOL=new OKTOOL($api_key,$secret_key,$client,$request);
        $res=$OKTOOL->api_to_database('userinfo');
        var_dump($res);
        //return view('home',['users'=>$users,'phone'=>SMSPHONE]);
    }
}
