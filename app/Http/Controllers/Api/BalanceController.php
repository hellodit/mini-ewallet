<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\FuncResponse; 
use App\User; 
use App\UserBalance; 
use App\UserBalanceHistory; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    use FuncResponse; 

    public function topup(Request $request){
        $validator = Validator::make($request->all(), [
            'ammount' => 'required|numeric|min:1000|max:99999',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->responseValidation($errors);
        }

        DB::beginTransaction();
        try {
            $user_balance = UserBalance::where('user_id',auth()->user()->id)->firstOrFail();
            $user_balance->balance_achieve =  $user_balance->balance; 
            $user_balance->balance += $request->ammount; 
            $user_balance->update(); 
            
            $history = new UserBalanceHistory; 
            $history->user_balance_id = $user_balance->id; 
            $history->balance_before = $user_balance->balance_achieve; 
            $history->balance_after = $user_balance->balance;
            $history->activity = 'topup'; 
            $history->type = 'debit';
            $history->ip = $request->ip(); 
            $history->location = $request->ip() == '127.0.0.1' ? 'localhost' : \Location::get($request->ip())->countryName; 
            $history->user_agent = $request->server('HTTP_USER_AGENT'); 
            $history->author = 'web'; 
            $history->save();
            DB::commit();

            $response = [
                'current_balance' => auth()->user()->balance
            ]; 

            return $this->responseInfo('Topup balance successful!!',$response);

        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseInternalServerError('Internal server error');
        }
    }

    public function transfer(Request $request){
        $validator = Validator::make($request->all(), [
            'ammount' => 'required|numeric|min:1000',
            'username' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->responseValidation($errors);
        }
        $user_balance = UserBalance::where('user_id',auth()->user()->id)->firstOrFail();
        
        if ($user_balance->balance < $request->ammount || $request->ammount > $user_balance->balance) {
            return $this->responseBadRequest("insufficient balance");
        }

        DB::beginTransaction();
        try {
 

            $user_balance->balance_achieve =  $user_balance->balance; 
            $user_balance->balance -= $request->ammount;
            $user_balance->update(); 

            $history = new UserBalanceHistory; 
            $history->user_balance_id = $user_balance->id; 
            $history->balance_before = $user_balance->balance_achieve; 
            $history->balance_after = $user_balance->balance;
            $history->activity = 'transfer to '.$request->username; 
            $history->type = 'credit';
            $history->ip = $request->ip(); 
            $history->location = $request->ip() == '127.0.0.1' ? 'localhost' : \Location::get($request->ip())->countryName; 
            $history->user_agent = $request->server('HTTP_USER_AGENT'); 
            $history->author = 'web'; 
            $history->save();
    
            $user_target = User::where('username','=',$request->username)->firstOrfail();
            $user_target_balance = UserBalance::where('user_id',$user_target->id)->firstOrFail();
            $user_target_balance->balance_achieve =  $user_target_balance->balance; 
            $user_target_balance->balance += $request->ammount;
            $user_target_balance->update(); 

            $history = new UserBalanceHistory; 
            $history->user_balance_id = $user_target_balance->id; 
            $history->balance_before = $user_target_balance->balance_achieve; 
            $history->balance_after = $user_target_balance->balance;
            $history->activity = 'recive transfer'; 
            $history->type = 'debit';
            $history->author =  auth()->user()->username;
            $history->save();
            DB::commit();

            $response = [ 
                'current_balance' =>  auth()->user()->balance
            ];
            return $this->responseInfo('Transfer to '.$request->username.' successful!!', $response);

        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseInternalServerError('Server internal error');
        }

    }
}
