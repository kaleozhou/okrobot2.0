<?php
namespace App\Http\Controllers;
use App\Models\Userinfo;
use App\Models\Orderinfo;
use App\Libraries\OKTOOL;
use DB;
use Log;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
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
        //$login_user->api_key=config('okcoin.api_key');
        //$login_user->secret_key=config('okcoin.secret_key');
        //$login_user->save();
        $login_user=$request->user();
        $OKTOOL=new OKTOOL($login_user);
        $newuserinfo=$OKTOOL->get_new_info('userinfo');
        $newticker=$OKTOOL->get_new_info('ticker');
        $newset=$OKTOOL->get_new_info('set');
        $orderinfos=Orderinfo::where('status','2')
            ->where('user_id',$login_user->id)
            ->orderBy('order_id','desc')
            ->simplePaginate(5);
        return view('home',['userinfo'=>$newuserinfo,'ticker'=>$newticker,'set'=>$newset,'orderinfos'=>$orderinfos]);
    }
    public function starttrade(Request $request){
        $login_user=$request->user();
        $login_user->autotrade=true;
        $login_user->save();
        $login_user=$request->user();
        $OKTOOL=new OKTOOL($login_user);
        $newuserinfo=$OKTOOL->get_new_info('userinfo');
        $newticker=$OKTOOL->get_new_info('ticker');
        $newset=$OKTOOL->get_new_info('set');
        $orderinfos=Orderinfo::where('status','2')
            ->where('user_id',$login_user->id)
            ->orderBy('order_id','desc')
            ->simplePaginate(5);
        return view('home',['userinfo'=>$newuserinfo,'ticker'=>$newticker,'set'=>$newset,'orderinfos'=>$orderinfos]);
    }
    public function stoptrade(Request $request){
        $login_user=$request->user();
        $login_user->autotrade=false;
        $login_user->save();
        $login_user=$request->user();
        $OKTOOL=new OKTOOL($login_user);
        $newuserinfo=$OKTOOL->get_new_info('userinfo');
        $newticker=$OKTOOL->get_new_info('ticker');
        $newset=$OKTOOL->get_new_info('set');
        $orderinfos=Orderinfo::where('status','2')
            ->where('user_id',$login_user->id)
            ->orderBy('order_id','desc')
            ->simplePaginate(5);
        return view('home',['userinfo'=>$newuserinfo,'ticker'=>$newticker,'set'=>$newset,'orderinfos'=>$orderinfos]);
    }

    /**
     * @access public 
     * @author kaleo <kaleo1990@hotmail.com>
     * @param  $user 传入用户模型
     * @return 
     */
    public function autotrade($user){
        //检测是否设置api_key
        try{
                if ($user->api_key!=null&&$user->secret_key!=null)
                {
                    $OKTOOL=new OKTOOL($user);
                    $res=$OKTOOL->update_data_database();
                    $res=$OKTOOL->autotrade();
                }
                else
                {
                    return false;
                    var_dump('请设置你的api_key和secret_key!');
                }
        }
        catch(exception $e){
            //修改设置
            $user->autotrade=false;
            $user->save();
            return false;
        }
    }
}
