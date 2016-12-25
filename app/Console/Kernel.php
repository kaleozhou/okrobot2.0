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
        $schedule->call(function()
        {
            //自动交易btc
            $this->autotrade('dotrade','btc_cny');
            //自动交易ltc
            $this->autotrade('dotrade','ltc_cny');
            //})->everyThirtyMinutes();
            // })->everyTenMinutes();
            })->everyFiveMinutes();
       // })->everyMinute();
        //更更新数据
        $schedule->call(function()
        {
            //自动更新btc
            $this->autotrade('update','btc_cny');
        })->everyMinute();
    }
    public function autotrade($operate,$symbol){
        switch ($operate) {
        case 'update':
            $users=User::all();
            //更新数据
            if (count($users)<1) {
                //                Log::info('没有用户自动交易');
            }
            else
            {
                for ($i = 0; $i < 8; $i++) {
                    foreach ($users as $user) {
                        try{
                            if ($user->api_key!=null&&$user->secret_key!=null)
                            {
                                $OKTOOL=new OKTOOL($user);
                                $res=$OKTOOL->update_data_database();
                                $newuserinfo=$OKTOOL->get_new_info('userinfo',$symbol);
                                //                                Log::info('name: '.$user->name.'已更新'.'cost'.$user->cost.'asset_net'.$newuserinfo->asset_net);
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
                        sleep(3);
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
                foreach ($users as $user) {
                    try{
                        if ($user->api_key!=null&&$user->secret_key!=null)
                        {
                            $OKTOOL=new OKTOOL($user);
                            $res=$OKTOOL->update_data_database();
                            $res=$OKTOOL->autotrade($symbol);
                            $newuserinfo=$OKTOOL->get_new_info('userinfo',$symbol);
                            Log::info($symbol.'-name: '.$user->name.' asset_net: '.$newuserinfo->asset_net.' asset_total: '.$newuserinfo->asset_total);
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
