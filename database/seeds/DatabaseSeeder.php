<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            [
                'name'=>'kaleo',
                'email'=>'kaleo1990@hotmail.com',
                'password'=>bcrypt('zh13275747670'),
                'cost'=>31513,
                'api_key'=>'7573fd61-7b8a-4132-814b-9536325c8460',
                'secret_key'=>'461D47D0FE52B28288E1285D8D899812'
            ]
        ]);
        DB::table('sysconfigs')->insert([
            ['name'=>'downline','value'=>0.9],
            ['name'=>'upline','value'=>3],//止盈值
            ['name'=>'uprate','value'=>1],//上浮率
            ['name'=>'downrate','value'=>1],//下浮动率
            ['name'=>'unit','value'=>0.1],//下单单位
            ['name'=>'klinetype','value'=>"15min"],//kline的周期
            ['name'=>'tradetype','value'=>1],//使用策略类型，1，2
            ['name'=>'api_key' ,'value'=> "7573fd61-7b8a-4132-814b-9536325c8460"],
            ['name'=>'secret_key','value'=> "461D47D0FE52B28288E1285D8D899812"],
            ['name'=>'smsusername','value'=>"kaleozhou"],//短信用户名
            ['name'=>'smspassword','value'=>"zh13275747670"],//短信密码
            ['name'=>'smsphone','value'=>"13635456575"]//短信手机号
        ]
        );

    }
}
