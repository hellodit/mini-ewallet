<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

trait FuncResponse
{
    public function responseData ($data){
        return new JsonResponse([
            'result' => true,
            'data'      => $data,
        ],200);
    }

    public function responseDataCount($data, $count = null){
        if($count == null){
            return new JsonResponse([
                'result'    => true,
                'count'      => count($data),
                'data'      => $data
            ],200);
        }else{
            return new JsonResponse([
                'result' => true,
                'count' => $count-1,
                'data' => $data
            ], 200);
        }
    }
    
    public function responseInfo($info, $result = null){
        if($result == null){
            return new JsonResponse([
                'result' => false,
                'data' => [],
                'info' => $info,
            ], 200);
        }else{
            return new JsonResponse([
                'result' => true,
                'data' => $result,
                'info' => $info,
            ], 200);
        }
    }

    public function responseValidation($info,$detail = ""){
        $message = 'Isian yang diberikan tidak valid';
        if ($detail == "") {
            return new JsonResponse([
                'message' => $message,
                'info' => $info,
            ], 400);
        }else{
            return new JsonResponse([
                'message'    => $message,
                'info'      => $info,
                'detail'      => $detail,
            ],400);
        }
    }
    public function responseBadRequest($message,$info = ""){
        if ($info == "") {
            return new JsonResponse([
                'message' => $message,
            ], 400);
        }else{
            return new JsonResponse([
                'message'    => $message,
                'info'      => $info,
            ],400);
        }
    }

    public function responseInternalServerError($info,$detail = ""){
        if ($detail == "") {
            return new JsonResponse([
                'result' => 'false',
                'info' => $info,
            ], 500);
        }else{
            return new JsonResponse([
                'result'    => 'false',
                'info'      => $info,
                'detail'      => $detail,
            ],500);
        }
    }


}
