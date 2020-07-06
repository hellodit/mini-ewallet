<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalanceHistory extends Model
{
    protected $table = 'user_balance_histories';

    protected $hidden = ['id','user_balance_id','updated_at'];
    
    public function balances()
    {
        return $this->belongsTo('App\Balance');
    }

}
