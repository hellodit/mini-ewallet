<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    protected $table = 'user_balances';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function histories()
    {
        return $this->hasMany('App\UserBalanceHistory');
    }
}
