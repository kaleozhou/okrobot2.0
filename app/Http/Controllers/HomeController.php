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
        $api_key=$request->user()->api_key;
        $secret_key=$request->user()->secret_key;
        if ($api_key==null) {
            $api_key=config('okcoin.api_key');
        }
        if ($secret_key==null) {
            $secret_key=config('okcoin.secret_key');
        }
        $client =new OKCoin(new ApikeyAuthentication($api_key,$secret_key));
        $OKTOOL=new OKTOOL($api_key,$secret_key,$client,$request);
        $res=$OKTOOL->update_data_database();
        $res=$OKTOOL->autotrade();
        $newuserinfo=$OKTOOL->get_new_info('userinfo');
        $newticker=$OKTOOL->get_new_info('ticker');
        $newset=$OKTOOL->get_new_info('set');
        $str='asset_net:'.$newuserinfo->asset_net;
        $str=$str.'|asset_total:'.$newuserinfo->asset_total;
        $str=$str.'|free_cny:'.$newuserinfo->free_cny;
        $str=$str.'|free_btc:'.$newuserinfo->free_btc;
        $str=$str.'|last_price:'.$newticker->last_price;
        $str=$str.'|dif_price:'.$newticker->dif_price;
        $str=$str.'|my_last_price:'.$newset->my_last_price;

        return view('home',['userinfo'=>$newuserinfo,'ticker'=>$newticker,'set'=>$newset]);
    }
}
