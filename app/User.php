<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //借款信息
    public function borrow()
    {
        return $this->hasone('App\Models\Borrow');
    }
    //k线
    public function klines()
    {
        return $this->hasmany('App\Models\Kline');
    }
    //订单信息
    public function orderinfos()
    {
        return $this->hasmany('App\Models\Orderinfo');
    }
    //设置
    public function set()
    {
        return $this->hasone('App\Models\Set');
    }
    //发送短信
    public function smss()
    {
        return $this->hasmany('App\Models\Sms');
    }
    //行情信息
    public function tickers()
    {
        return $this->hasmany('App\Models\Ticker');
    }
    //下单信息
    public function trades()
    {
        return $this->hasmany('App\Models\Trade');
    }
    //趋势信息
    public function trends()
    {
        return $this->hasmany('App\Models\Trend');
    }
    //用户信息
    public function userinfos()
    {
        return $this->hasmany('App\Models\Userinfo');
    }

}
