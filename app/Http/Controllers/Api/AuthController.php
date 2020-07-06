<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use App\UserBalance; 
use App\UserBalanceHistory; 
use App\Utils\FuncResponse; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use FuncResponse; 

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->responseValidation($errors);
        }

        DB::beginTransaction();
        try {
            $user = new User; 
            $user->name = $request->name;
            $user->username = $request->username; 
            $user->email = $request->email;
            $user->password = bcrypt($request->password); 
            $user->save(); 
            $token = $user->createToken('authToken')->accessToken; 


            $balance = new UserBalance; 
            $balance->user_id = $user->id;
            $balance->balance = 0;
            $balance->balance_achieve = 0;
            $balance->save();
            
            $history = New UserBalanceHistory; 
            $history->user_balance_id = $balance->id; 
            $history->balance_before = 0; 
            $history->balance_after = 0; 
            $history->activity = 'initial ballance';
            $history->type = 'debit';
            $history->ip = $request->ip(); 
            $history->author = 'system'; 
            $history->save();
    
            DB::commit();

            $response = [ 
                'user' => $user, 
                'access_token' =>  $token
            ];

            return $this->responseData($response);

        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseInternalServerError('Internal server error');
        }
    }


    public function login(Request $request){
        $login = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($login)) {
            return  $this->responseBadRequest('Invalid Credentials');
        }

        $token =  auth()->user()->createToken('authToken')->accessToken; 
        
        $response = [ 
            'user' =>  auth()->user(), 
            'access_token' =>  $token
        ];

        return $this->responseData($response);
    }


    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return $this->responseInfo('You have been successfully logged out!', null);
    }
    
}
