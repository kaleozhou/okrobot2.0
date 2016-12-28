<?php
namespace App\Console;
use Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;
use App\Libraries\OKTOOL;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $interval=config('okcoin.interval');

        switch ($interval) {
        case '1min':
            $schedule->call(function()
            {
                $tradetype=config('okcoin.tradetype');
                $this->autotrade('dotrade','btc_cny',$tradetype);
                $this->autotrade('dotrade','ltc_cny',$tradetype);
            })->everyMinute();
            break;
        case '5min':
            $schedule->call(function()
            {
                $tradetype=config('okcoin.tradetype');
                $this->autotrade('dotrade','btc_cny',$tradetype);
                $this->autotrade('dotrade','ltc_cny',$tradetype);
            })->everyFiveMinutes();
            break;
        case '10min':
            $schedule->call(function()
            {
                $tradetype=config('okcoin.tradetype');
                $this->autotrade('dotrade','btc_cny',$tradetype);
                $this->autotrade('dotrade','ltc_cny',$tradetype);
            })->everyFiveMinutes();
            break;
        case '10min':
            $schedule->call(function()
            {
                $tradetype=config('okcoin.tradetype');
                $this->autotrade('dotrade','btc_cny',$tradetype);
                $this->autotrade('dotrade','ltc_cny',$tradetype);
            })->everyTenMinutes();
            break;
        case '30min':
            $schedule->call(function()
            {
                $tradetype=config('okcoin.tradetype');
                $this->autotrade('dotrade','btc_cny',$tradetype);
                $this->autotrade('dotrade','ltc_cny',$tradetype);
            })->everyThirtyMinutes();
            break;
        case '1h':
            $schedule->call(function()
            {
                $tradetype=config('okcoin.tradetype');
                $this->autotrade('dotrade','btc_cny',$tradetype);
                $this->autotrade('dotrade','ltc_cny',$tradetype);
            })->hourly();
            break;
        default:
            break;
        }
        $schedule->call(function()
        {
            $tradetype=config('okcoin.tradetype');
            for ($i = 0; $i < 8; $i++) {
                // code...
                $this->autotrade('update','btc_cny',$tradetype);
                sleep(3);
            }
        })->everyMinute();
    }
    /**
     * @access 
     * @author kaleo <kaleo1990@hotmail.com>
     * @param operate   update  更新数据
     *                  totrade 自动交易  
     * @param symbol    btc_cny 
     *                  ltc_cny
     * @param tradetype 1   策略一
     *                  2   策略二
     * @return
     */
    public function autotrade($operate,$symbol,$tradetype){
        switch ($operate) {
        case 'update':
            $users=User::all();
            //更新数据
            if (count($users)<1) {
                //                Log::info('没有用户自动交易');
            }
            else
            {
                foreach ($users as $user) {
                    try{
                        if ($user->api_key!=null&&$user->secret_key!=null)
                        {
                            $OKTOOL=new OKTOOL($user);
                            $res=$OKTOOL->update_data_database();
                            $newuserinfo=$OKTOOL->get_new_info('userinfo',$symbol);
                        }
                        else
                        {
                            Log::info('name: '.$user->name.' 请设置你的api_key和secret_key!');
                        }
                    }
                    catch(exception $e){
                        //修改设置
                        $user->btc_autotrade=false;
                        $user->ltc_autotrade=false;
                        $user->save();
                    }
                }
            }
            break;
        case 'dotrade':
            switch ($symbol) {
            case 'btc_cny':
                $users=User::where('btc_autotrade',true)->get();
                break;
            case 'ltc_cny':
                $users=User::where('ltc_autotrade',true)->get();
                break;
            default:
                $users=User::where('btc_autotrade',true)->get();
                break;
            }
            //自动交易
            if (count($users)<1) {
                //               Log::info($symbol.'-没有用户自动交易');
            }
            else
            {
                for ($i = 0; $i < 7; $i++) {
                     // code...
                foreach ($users as $user) {
                    try{
                        if ($user->api_key!=null&&$user->secret_key!=null)
                        {
                            $OKTOOL=new OKTOOL($user);
                            $res=$OKTOOL->update_data_database();
                            switch ($tradetype) {
                            case 1:
                                $res=$OKTOOL->autotrade($symbol);
                                break;
                            case 2:
                                $res=$OKTOOL->autotrade2($symbol);
                                break;
                            default:
                                $res=$OKTOOL->autotrade($symbol);
                                break;
                            }
                            $newuserinfo=$OKTOOL->get_new_info('userinfo',$symbol);
                            Log::info('tradetype:'.$tradetype.'-'.$symbol.'-:'.$user->name.'-cost:'.$user->cost.'-asset_net:'.$newuserinfo->asset_net.'-asset_total: '.$newuserinfo->asset_total);
                        }
                        else
                        {
                            Log::info('name: '.$user->name.' 请设置你的api_key和secret_key!');
                        }
                    }
                    catch(exception $e){
                        //修改设置
                        $user->btc_autotrade=false;
                        $user->ltc_autotrade=false;
                        $user->save();
                    }
                }
                sleep(2);
                }
            }
            break;
        default:
            break;
        }
    }
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
