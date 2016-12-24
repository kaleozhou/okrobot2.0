<?php 
namespace App\Libraries;
use App\Models\Userinfo;
use App\Models\Ticker;
use App\Models\Orderinfo;
use App\Models\Set;
use App\Models\Trend;
use App\Models\Trade;
use App\Models\Sms;
use App\Models\Kline;
use App\Models\Borrow;
use App\OKCoin\OKCoin;
use App\OKCoin\ApiKeyAuthentication;
use Illuminate\Http\Request;
use DB;
class OKTOOL{
    public $api_key;
    public $secret_key;
    public $client;
    public $user_id;
    /**
     * @access 登陆用户 
     * @author kaleo <kaleo1990@hotmail.com>
     * @param $api_key 用户api
     * @param $secret_key 
     * @param $client OKCoin类
     * @return
     */
    public function __construct($login_user)
    {
        $this->api_key=$login_user->api_key;
        $this->secret_key=$login_user->secret_key;
        $this->client=new OKCoin(new ApikeyAuthentication($this->api_key,$this->secret_key));
        $this->user_id=$login_user->id;
    }
    /**
     * @access 获取api数据存入数据库 
     * @author kaleo <kaleo1990@hotmail.com>
     * @param
     * @return
     */
    public function api_to_database($tablename){
        //用户信息
        $res=false;
        switch ($tablename) {
        case 'userinfo':
            //获取用户信息
            $params = array('api_key' => $this->api_key);
            $result = $this->client -> userinfoApi($params);
            //todatabase
            if ($result->result) {
                $userinfo=new Userinfo();
                $userinfo->user_id=$this->user_id;
                $userinfo->asset_net=$result->info->funds->asset->net;
                $userinfo->asset_total=$result->info->funds->asset->total;
                $userinfo->borrow_btc=$result->info->funds->borrow->btc;
                $userinfo->borrow_cny=$result->info->funds->borrow->cny;
                $userinfo->borrow_ltc=$result->info->funds->borrow->ltc;
                $userinfo->free_btc=$result->info->funds->free->btc;
                $userinfo->free_cny=$result->info->funds->free->cny;
                $userinfo->free_ltc=$result->info->funds->free->ltc;
                $userinfo->freezed_btc=$result->info->funds->freezed->btc;
                $userinfo->freezed_cny=$result->info->funds->freezed->cny;
                $userinfo->freezed_ltc=$result->info->funds->freezed->ltc;
                $userinfo->union_fund='';
                $res=$userinfo->save();
            }
            else
            {
                return $result->error_code;
            }
            return $res;
            break;
        case 'ticker':
            //获取OKCoin行情（盘口数据）
            //获取btc的行情
            $symbol='btc_cny';
            $params = array('symbol' => $symbol);
            $result = $this->client-> tickerApi($params);
            $ticker=new Ticker();
            $ticker->buy=$result->ticker->buy;
            $ticker->high=$result->ticker->high;
            $ticker->last_price=$result->ticker->last;
            $ticker->low=$result->ticker->low;
            $ticker->sell=$result->ticker->sell;
            $ticker->vol=$result->ticker->vol;
            $ticker->symbol=$symbol;
            $res=$ticker->save();
            //获取ltc的行情
            $symbol='ltc_cny';
            $params = array('symbol' => $symbol);
            $result = $this->client-> tickerApi($params);
            $ticker=new Ticker();
            $ticker->buy=$result->ticker->buy;
            $ticker->high=$result->ticker->high;
            $ticker->last_price=$result->ticker->last;
            $ticker->low=$result->ticker->low;
            $ticker->sell=$result->ticker->sell;
            $ticker->vol=$result->ticker->vol;
            $ticker->symbol=$symbol;
            $res=$ticker->save();
            break;
        case 'orderinfo':
            //批量获取用户订单
            //btc订单
            $symbol='btc_cny';
            $params = array('api_key' => $this->api_key, 'symbol' => $symbol, 'status' => 2, 'current_page' => '1', 'page_length' => '15');
            $result = $this->client-> orderHistoryApi($params);
            if($result->result)
            {
                $ordersresult=$result->orders;
                foreach ($ordersresult as $key) {
                    //取出api结果
                    $orderinfo=Orderinfo::firstOrNew(['order_id'=>$key->order_id]);
                    $orderinfo->user_id=$this->user_id;
                    $orderinfo->amount=$key->amount;  
                    $orderinfo->deal_amount=$key->deal_amount;  
                    $orderinfo->avg_price=$key->avg_price;
                    $orderinfo->create_date=date("Y/m/d H:i:s",substr($key->create_date,0,strlen($key->create_date)-3));  
                    $orderinfo->order_id=$key->order_id;  
                    $orderinfo->price=$key->price;  
                    $orderinfo->status=$key->status;  
                    $orderinfo->symbol=$key->symbol;  
                    $orderinfo->ordertype=$key->type;  
                    $orderinfo->save();
                }
                if (count($ordersresult)<1) {
                    Orderinfo::where('status',1)->where('user_id',$this->user_id)->update(['status'=>-1]);
                }
            }
            else
            {
                return $result->error_code;
            }
            $symbol='ltc_cny';
            $params = array('api_key' => $this->api_key, 'symbol' => $symbol, 'status' => 2, 'current_page' => '1', 'page_length' => '15');
            $result = $this->client-> orderHistoryApi($params);
            if($result->result)
            {
                $ordersresult=$result->orders;
                foreach ($ordersresult as $key) {
                    //取出api结果
                    $orderinfo=Orderinfo::firstOrNew(['order_id'=>$key->order_id]);
                    $orderinfo->user_id=$this->user_id;
                    $orderinfo->amount=$key->amount;  
                    $orderinfo->deal_amount=$key->deal_amount;  
                    $orderinfo->avg_price=$key->avg_price;
                    $orderinfo->create_date=date("Y/m/d H:i:s",substr($key->create_date,0,strlen($key->create_date)-3));  
                    $orderinfo->order_id=$key->order_id;  
                    $orderinfo->price=$key->price;  
                    $orderinfo->status=$key->status;  
                    $orderinfo->symbol=$key->symbol;  
                    $orderinfo->ordertype=$key->type;  
                    $orderinfo->save();
                }
                if (count($ordersresult)<1) {
                    Orderinfo::where('status',1)->where('user_id',$this->user_id)->update(['status'=>-1]);
                }
            }
            else
            {
                return $result->error_code;
            }
            break;
        case 'kline':
            //获取比特币5分钟k线图数据20条
            //btc kline
            $symbol='btc_cny';
            $type=config('okcoin.klinetype');
            $params = array('symbol' => $symbol, 'type' =>$type, 'size' => 100);
            $result = $this->client->klineDataApi($params);
            foreach ($result as $reskline) {
                //取出每个kline
                $kline=Kline::firstOrNew(['create_date'=>date("Y/m/d H:i:s",substr($reskline[0],0,strlen($reskline[0])-3)),'symbol'=>$symbol]);
                $kline->create_date=date("Y/m/d H:i:s",substr($reskline[0],0,strlen($reskline[0])-3));  
                $kline->start_price=$reskline[1];
                $kline->high_price=$reskline[2];
                $kline->low_price=$reskline[3];
                $kline->over_price=$reskline[4];
                $kline->vol=$reskline[5];
                $kline->dif_price=$kline['high_price']-$kline['low_price'];
                $kline->symbol=$symbol;
                $kline->save();
            }
            //ltc_cny kline
            $symbol='ltc_cny';
            $params = array('symbol' => $symbol, 'type' =>$type, 'size' => 100);
            $result = $this->client->klineDataApi($params);
            foreach ($result as $reskline) {
                //取出每个kline
                $kline=Kline::firstOrNew(['create_date'=>date("Y/m/d H:i:s",substr($reskline[0],0,strlen($reskline[0])-3)),'symbol'=>$symbol]);
                $kline->create_date=date("Y/m/d H:i:s",substr($reskline[0],0,strlen($reskline[0])-3));  
                $kline->start_price=$reskline[1];
                $kline->high_price=$reskline[2];
                $kline->low_price=$reskline[3];
                $kline->over_price=$reskline[4];
                $kline->vol=$reskline[5];
                $kline->dif_price=$kline['high_price']-$kline['low_price'];
                $kline->symbol=$symbol;
                $kline->save();
            }
            break;
        case 'set':
            //更新上次设置set，上次成交价my_last_price，成交单位unit，价值波动n_price
            $set=Set::firstOrNew(['user_id'=>$this->user_id]);
            //btc 设置
            $symbol='btc_cny';
            //获取btc上次成交金额
            $neworderinfo=$this->get_new_info('orderinfo',$symbol);
            if (!empty($neworderinfo)) {
                $set->btc_my_last_price=$neworderinfo->avg_price;
            }
            //根据kline计算价值波数值20条信息
            $btc_n_price=Kline::where('symbol',$symbol)->orderBy('id','desc')->take(100)->avg('dif_price');
            $set->btc_n_price=$btc_n_price;
            //ltc设置
            $symbol='ltc_cny';
            //获取btc上次成交金额
            $neworderinfo=$this->get_new_info('orderinfo',$symbol);
            if (!empty($neworderinfo)) {
                $set->ltc_my_last_price=$neworderinfo->avg_price;
            }
            //根据kline计算价值波数值20条信息
            $ltc_n_price=Kline::where('symbol',$symbol)->orderBy('id','desc')->take(100)->avg('dif_price');
            $set->ltc_n_price=$ltc_n_price;
            $set->user_id=$this->user_id;
            //暂为使用
            $set->uprate=config('okcoin.uprate');
            $set->unit=config('okcoin.unit');
            $set->unitrate=config('okcoin.unitrate');
            $set->upline=config('okcoin.upline');
            $set->downline=config('okcoin.downline');
            $set->downrate=config('okcoin.downrate');
            $set->save();
            break;
        case 'borrow':
            //api
            //btc设置
            $symbol='btc_cny';
            $params = array('api_key' => $this->api_key, 'symbol' => $symbol);
            $result = $this->client-> borrowsInfoApi($params);
            if($result->result)
            {
                //todatabase
                $borrow=Borrow::firstOrNew(['user_id'=>$this->user_id]);
                $borrow->user_id=$this->user_id;
                $borrow->borrow_btc=$result->borrow_btc;
                $borrow->borrow_cny=$result->borrow_cny;
                $borrow->borrow_ltc=$result->borrow_ltc;
                $borrow->can_borrow=$result->can_borrow;
                $borrow->interest_btc=$result->interest_btc;
                $borrow->interest_cny=$result->interest_cny;
                $borrow->interest_ltc=$result->interest_ltc;
                $borrow->today_interest_btc=$result->today_interest_btc;
                $borrow->today_interest_ltc=$result->today_interest_ltc;
                $borrow->today_interest_cny=$result->today_interest_cny;
                $borrow->result=$result->result;
                $borrow->save();	
            }
            else
            {
                return $result->error_code;
            }
            //ltc设置
            $symbol='ltc_cny';
            $params = array('api_key' => $this->api_key, 'symbol' => $symbol);
            $result = $this->client-> borrowsInfoApi($params);
            if($result->result)
            {
                //todatabase
                $borrow=Borrow::firstOrNew(['user_id'=>$this->user_id]);
                $borrow->user_id=$this->user_id;
                $borrow->borrow_btc=$result->borrow_btc;
                $borrow->borrow_cny=$result->borrow_cny;
                $borrow->borrow_ltc=$result->borrow_ltc;
                $borrow->can_borrow=$result->can_borrow;
                $borrow->interest_btc=$result->interest_btc;
                $borrow->interest_cny=$result->interest_cny;
                $borrow->interest_ltc=$result->interest_ltc;
                $borrow->today_interest_btc=$result->today_interest_btc;
                $borrow->today_interest_ltc=$result->today_interest_ltc;
                $borrow->today_interest_cny=$result->today_interest_cny;
                $borrow->result=$result->result;
                $borrow->save();	
            }
            else
            {
                return $result->error_code;
            }
            break;
        default:
            break;
        }
    }
    //刷新数据
    public function update_data_database(){
        try{
            $res=$this->api_to_database('userinfo');
            $res=$this->api_to_database('orderinfo');
            $res=$this->api_to_database('kline');
            $res=$this->api_to_database('set');
            $res=$this->api_to_database('ticker');
            $res=$this->api_to_database('borrow');
            if($res!=null)
            {
                return $res;
            }
        }
        catch(Exception $e)
        {
            var_dump($e);
        }
    }
    //从数据库获取最新信息
    public function get_new_info($tablename,$symbol){
        switch ($tablename) {
        case 'userinfo':
            $res=$newuserinfo=Userinfo::where('user_id',$this->user_id)->orderBy('id','desc')->first();
            return $res;
            break;
        case 'ticker':
            $res=$newticker=Ticker::where('symbol',$symbol)->orderBy('id','desc')->first();
            return $res;
            break;
        case 'orderinfo':
            $res=$newticker=Orderinfo::where('user_id',$this->user_id)->where('symbol',$symbol)->where('status',2)->orderBy('order_id','desc')->first();
            return $res;
            break;
        case 'kline':
            $res=$newkline=Kline::where('symbol',$symbol)->orderBy('create_date','desc')->first();
            return $res;
            break;
        case 'set':
            $res=$newset=Set::where('user_id',$this->user_id)->orderBy('id','desc')->first();
            return $res;
            break;
        case 'trend':
            $res=$newtrend=Trend::where('user_id',$this->user_id)->where('symbol',$symbol)->orderBy('id','desc')->first();
            return $res;
            break;
        case 'borrow':
            $res=$newborrow=Borrow::where('user_id',$this->user_id)->where('symbol',$symbol)->orderBy('id','desc')->first();
            return $res;
            break;
        default:
            // code...
            break;
        }
    }
    //发送通知短信
    public function send_sms($content){
        $newsms=new Sms();
        $username=config('okcoin.smsusername');
        $password=md5(config('okcion.smspassword'));
        $phone=config('okcoin.smsphone');
        $sms_type='短信宝';
        $url="http://api.smsbao.com/sms?u=$username&p=$password&m=$phone&c=$content";
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER,0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        //执行命令
        $result = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        $newsms->username=$username;
        $newsms->user_id=$this->user_id;
        $newsms->password=$password;
        $newsms->phone=$phone;
        $newsms->content=$content;
        $newsms->result=$result;
        $newsms->sms_type=$sms_type;
        $newsms->create_date=date('Y/m/d H:i:s');
        $newsms->save();
    }
    //下单
    public function totrade($symbol,$tradetype,$value,$last_trade_type,$last_trade_hits,$asset_net){
        //创建订单
        $trade=new Trade();
        //创建趋势
        $trend=new Trend();
        if ($tradetype=='sell_market') {
            $params = array('api_key' => $this->api_key, 'symbol' => $symbol, 'type' => $tradetype,  'amount' => $value);
            $trade->amount=$value;
        }
        else
        {
            $params = array('api_key' => $this->api_key, 'symbol' => $symbol, 'type' => $tradetype,  'price' => $value);
            $trade->price=$value;
        }
        $result = $this->client->tradeApi($params);
        if ($result->result) {
            $trade->order_id=$result->order_id;
        }
        //插入数据库
        $trade->user_id=$this->user_id;
        $trade->symbol=$symbol;
        $trade->tradetype=$tradetype;
        $trade->result=$result->result;
        $trade->asset_net=$asset_net;
        $trade->save();
        //插入trend的
        $trend->user_id=$this->user_id;
        $trend->last_trade_hits=$last_trade_hits;
        $trend->last_trade_type=$last_trade_type;
        $trend->symbol=$symbol;
        $trend->save(); 
    }
    //自动下单函数
    public function autotrade($symbol){
        try{
            //获取当前行情和基最新成交价价
            $newticker=$this->get_new_info('ticker',$symbol);
            if($newticker!=null){
                $last_price=$newticker->last_price;
                //最小购买金额计算
            }
            //获取趋势
            $newtrend=$this->get_new_info('trend',$symbol);
            $last_trade_type='';
            $last_trade_hits=1;
            if ($newtrend!=null) {
                $last_trade_type=$newtrend->last_trade_type;
                $last_trade_hits=$newtrend->last_trade_hits;
            }
            //获取设置
            $newset=$this->get_new_info('set',$symbol);
            if($newset!=null){

                switch ($symbol) {
                case 'btc_cny':
                    $my_last_price=$newset->btc_my_last_price;
                    $n_price=$newset->btc_n_price;
                $smallprice=$last_price/99;
                    break;
                case 'ltc_cny':
                    $my_last_price=$newset->ltc_my_last_price;
                    $n_price=$newset->ltc_n_price;
                $smallprice=$last_price/9;
                    break;
                default:
                    break;
                }
                $unit=$newset->unit;
                $uprate=$newset->uprate;
                $downrate=$newset->downrate;
                //设置止盈止损
                $downline=$newset->downline;
                $upline=$newset->upline;
                $unitrate=$newset->unitrate;
                $unit=$newset->unit;
            }
            //获取当前用户信息
            $newuserinfo=$this->get_new_info('userinfo',$symbol);
            if ($newuserinfo!=null) {
                $free_cny=$newuserinfo->free_cny;
                $free_btc=$newuserinfo->free_btc;
                $free_ltc=$newuserinfo->free_ltc;
                $asset_total=$newuserinfo->asset_total;
                $asset_net=$newuserinfo->asset_net;
            }
            $autoresult_order_id="";
            //判断接下来是买还是卖
            $dif=$last_price-$my_last_price;
            //创建趋势单
            if ($asset_net>$downline&&$asset_net<$upline)
            {
                if ($dif>0)
                {
                    //价格在上升
                    //判断是否达到触发值
                    //如果当前价格$last_price低于$my_last_price价值波动一个$n_price,
                    if(abs($dif)>=$uprate*$n_price)
                    {
                        //买入一个单位的
                        if ($last_trade_type='up_1') {
                            $last_trade_hits++;
                        }
                        else
                        {
                            $last_trade_hits=1;
                        }
                        $tradetype='buy_market';
                        //买入一个单位，小额建仓
                        $price=$unit*$asset_total;
                        if ($price>$free_cny)
                        {
                            $price=$free_cny;
                        }
                        if($price>=$smallprice&&$price<=$free_cny)
                        {
                            $res=$this->totrade($symbol,$tradetype,$price,$last_trade_type,$last_trade_hits,$asset_net);
                        }
                        else
                        {
                            //卖出0.01btc比更新价格
                        switch ($symbol) {
                        case 'btc_cny':
                            $amount=0.01;
                            break;
                        case 'ltc_cny':
                            $amount=0.1;
                            break;
                        default:
                            $amount=0.01;
                            break;
                        }
                            $tradetype='sell_market';
                            $res=$this->totrade($symbol,$tradetype,$amount,$last_trade_type,$last_trade_hits,$asset_net);
                            $this->send_sms('我在上涨，没有钱买了');
                        }
                    }
                }
                else
                {
                    //价格在下降，买单
                    //判断是否达到出发值
                    if(abs($dif)>=$downrate*$n_price)
                    {
                        //下卖单锁定利润
                        switch ($symbol) {
                        case 'btc_cny':
                            $amount=$free_btc;
                            $amountunit=0.01;
                            break;
                        case 'ltc_cny':
                            $amount=$free_ltc;
                            $amountunit=0.1;
                            break;
                        default:
                            $amount=$free_btc;
                            break;
                        }
                        if ($last_trade_type='down_1') {
                            $last_trade_hits++;
                        }
                        else
                        {
                            $last_trade_hits=1;
                        }
                        $last_trade_type='down_1';
                        if ($amount>$amountunit) {
                            $tradetype='sell_market';
                            $res=$this->totrade($symbol,$tradetype,$amount,$last_trade_type,$last_trade_hits,$asset_net);
                        }
                        else
                        {
                            //卖完了
                            $price=$smallprice;
                            $tradetype='buy_market';
                            $res=$this->totrade($symbol,$tradetype,$price,$last_trade_type,$last_trade_hits,$asset_net);
                        }
                    }
                }
            }
            else
            {
                //卖出所有的币止损
                        switch ($symbol) {
                        case 'btc_cny':
                            $amount=$free_btc;
                            $amountunit=0.01;
                            break;
                        case 'ltc_cny':
                            $amount=$free_ltc;
                            $amountunit=0.1;
                            break;
                        default:
                            $amount=$free_btc;
                            break;
                        }
                $last_trade_type='down_1';
                if ($amount>$amountunit) {
                    $last_trade_hits++;
                    $tradetype='sell_market';
                    $res=$this->totrade($symbol,$tradetype,$amount,$last_trade_type,$last_trade_hits,$asset_net);
                }
                else
                {
                    //卖完了
                    //判断是否是连击
                    $price=$smallprice;
                    $tradetype='buy_market';
                    $last_trade_hits++;
                    $res=$this->totrade($symbol,$tradetype,$price,$last_trade_type,$last_trade_hits,$asset_net);
                }
                //停止工作
                $autoresult_order_id='upline';
                $sms='已经止盈！';
                if ($asset_net<=DOWNLINE) {
                    $autoresult_order_id='downline';
                    $sms='已经止损！';
                }
                //发送通知
                $this->send_sms($sms);
            }
        }
        catch(Exception $e)
        {
            return $e;
        }
    }
}
?>
