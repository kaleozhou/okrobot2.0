<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kline extends Model
{
    //
    protected $fillable=['create_date'];
    //与User的一对多逆向关系
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
