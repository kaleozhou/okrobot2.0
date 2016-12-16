<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderinfo extends Model
{
    //
    protected $fillable=['order_id'];
    //与User的一对多逆向关系
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
