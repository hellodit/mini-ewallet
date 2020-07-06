<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalanceHistory extends Model
{
    protected $table = 'user_balance_histories';

    public function balances()
    {
        return $this->belongsTo('App\Balance');
    }

}
