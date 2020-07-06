<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\FuncResponse; 

class UserController extends Controller
{
    use FuncResponse; 

    public function profile(){
        $data = auth()->user()->with('balance')->get();
        return $this->responseData($data);
    }

    public function history(){
        $data = auth()->user()->with('balance.histories')->get();
        return $this->responseData($data);
    }
}
