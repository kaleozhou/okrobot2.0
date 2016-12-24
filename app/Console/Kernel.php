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
            $users=User::where('autotrade',true)->get();
            if (count($users)<1) {
                Log::info('没有用户自动交易');
            }
            else
            {
                    foreach ($users as $user) {
                        try{
                            if ($user->api_key!=null&&$user->secret_key!=null)
                            {
                                $OKTOOL=new OKTOOL($user);
                                $res=$OKTOOL->update_data_database();
                                $res=$OKTOOL->autotrade();
                                $newuserinfo=$OKTOOL->get_new_info('userinfo');
                                Log::info('name: '.$user->name.' asset_net: '.$newuserinfo->asset_net.' asset_total: '.$newuserinfo->asset_total);
                            }
                            else
                            {
                                Log::info('name: '.$user->name.' 请设置你的api_key和secret_key!');
                            }
                        }
                        catch(exception $e){
                            //修改设置
                            $user->autotrade=false;
                            $user->save();
                        }
                    }
            }
        //})->everyThirtyMinutes();
       // })->everyTenMinutes();
        })->everyFiveMinutes();
        //更型数据
        $schedule->call(function()
        {
            $users=User::where('autotrade',true)->get();
            if (count($users)<1) {
                Log::info('没有用户自动交易');
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
                                $newuserinfo=$OKTOOL->get_new_info('userinfo');
//                                Log::info('name: '.$user->name.'更新');
                            }
                            else
                            {
                                Log::info('name: '.$user->name.' 请设置你的api_key和secret_key!');
                            }
                        }
                        catch(exception $e){
                            //修改设置
                            $user->autotrade=false;
                            $user->save();
                        }
                        sleep(3);
                    }
                }
            }
        })->everyMinute();
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
