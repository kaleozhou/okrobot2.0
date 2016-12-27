<?php
# ******************************************************
# author       : kaleo
# last modified: 2016-12-14 14:32
# email        : kaleo1990@hotmail.com
# filename     : okcoin.php
# description  : 
# ******************************************************
return[
    //重要参数
    'downline'=>5500,//初始化止损值
    'upline'=>100000,//止盈值
    'uprate'=>0.4,//上浮率
    'downrate'=>0.4,//下浮动率
    'unit'=>0.33,//下单单位
    'klinetype'=>"3min",//kline的周期
    'tradetype'=>2,//使用策略类型，1，2
    //未使用参数
    'api_key' => "7573fd61-7b8a-4132-814b-9536325c8460",
    'secret_key'=> "461D47D0FE52B28288E1285D8D899812",
    'unitrate'=>0.5,//买入，卖出对价值波动的比率
    'smsusername'=>"kaleozhou",//短信用户名
    'smspassword'=>"zh13275747670",//短信密码
    'smsphone'=>"13635456575"//短信手机号
];

