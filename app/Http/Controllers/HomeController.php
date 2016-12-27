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
    public $error;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->error=false;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->api_key==null||$request->user()->secret_key==null) {
            $this->error='请设置您的api_key和secret_key';
        }
        $login_user=$request->user();
        $OKTOOL=new OKTOOL($login_user);
        $symbol='btc_cny';
        $newuserinfo=$OKTOOL->get_new_info('userinfo',$symbol);
        $btc_ticker=$OKTOOL->get_new_info('ticker',$symbol);
        $newset=$OKTOOL->get_new_info('set',$symbol);
        $orderinfos=Orderinfo::where('status','2')
            ->where('user_id',$login_user->id)
            ->orderBy('create_date','desc')
            ->simplePaginate(5);
        $symbol='ltc_cny';
        $ltc_ticker=$OKTOOL->get_new_info('ticker',$symbol);
        //计算利润
        if($login_user->cost>0&&!empty($newuserinfo))
        {
            $profit=($newuserinfo->asset_total-$login_user->cost)*100/$login_user->cost;
        }
        else
        {
            $profit=0;
        }
        return view('home',['userinfo'=>$newuserinfo,'btc_ticker'=>$btc_ticker,'ltc_ticker'=>$ltc_ticker,'set'=>$newset,'orderinfos'=>$orderinfos,'user'=>$login_user,'error'=>$this->error,'profit'=>$profit]);
    }
    /**
     *设置开始自动交易
     * @access 
     * @author kaleo <kaleo1990@hotmail.com>
     * @param
     * @return
     */
    public function startbtc(Request $request){
        if ($request->user()->api_key==null||$request->user()->secret_key==null) {
            $this->error='请设置您的api_key和secret_key';
        }
        $login_user=$request->user();
        if ($login_user->api_key!=null&&$login_user->secret_key!=null)
        {
            $login_user->btc_autotrade=true;
            $login_user->save();
        }
        return redirect('home');
    }
    public function startltc(Request $request){
        if ($request->user()->api_key==null||$request->user()->secret_key==null) {
            $this->error='请设置您的api_key和secret_key';
        }
        $login_user=$request->user();
        if ($login_user->api_key!=null&&$login_user->secret_key!=null)
        {
            $login_user->ltc_autotrade=true;
            $login_user->save();
        }
        return redirect('home');
    }
    /**
     * 设置关闭自动交易
     * @access 
     * @author kaleo <kaleo1990@hotmail.com>
     * @param
     * @return
     */
    public function stopbtc(Request $request){
        if ($request->user()->api_key==null||$request->user()->secret_key==null) {
            $this->error='请设置您的api_key和secret_key';
        }
        $login_user=$request->user();
        $login_user->btc_autotrade=false;
        $login_user->save();
        return redirect('home');
    }
    public function stopltc(Request $request){
        if ($request->user()->api_key==null||$request->user()->secret_key==null) {
            $this->error='请设置您的api_key和secret_key';
        }
        $login_user=$request->user();
        $login_user->ltc_autotrade=false;
        $login_user->save();
        return redirect('home');
    }

}
