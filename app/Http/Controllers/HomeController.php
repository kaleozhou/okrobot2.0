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
        $login_user->api_key=congig('okcoin.api_key');
        $login_user->secret_key=congig('okcoin.secret_key');
        $login_user->save();
        if ($login_user->api_key!=null&&$login_user->secret_key!=null) {
        $OKTOOL=new OKTOOL($login_user);
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
        else
        {
            var_dump('请设置你的api_key和secret_key!');
        }
    }
}
