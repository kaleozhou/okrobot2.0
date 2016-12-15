<?php
namespace App\Http\Controllers;
use App\Models\Userinfo;
use App\Models\Orderinfo;
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
        $login_user=$request->user();
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
        $orderinfos=Orderinfo::where('status','2')
                            ->where('user_id',$login_user->id)
                            ->orderBy('order_id','desc')
                            ->simplePaginate(5);
        return view('home',['userinfo'=>$newuserinfo,'ticker'=>$newticker,'set'=>$newset,'orderinfos'=>$orderinfos]);
    }
}
