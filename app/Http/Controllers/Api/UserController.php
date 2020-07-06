<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\FuncResponse; 
use App\User; 

class UserController extends Controller
{
    use FuncResponse; 

    public function profile(){
        $data = User::whereId(auth()->user()->id)->with('balance')->first();
        return $this->responseData($data);
    }

    public function history(){
        $data = auth()->user()->with('balance.histories')->get();
        return $this->responseData($data);
    }
}
