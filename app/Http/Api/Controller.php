<?php

namespace App\Http\Api;

// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public function responseJson($data,...$other) {
    //     // $code = isset($info['code']) ? $info['code'] : 200;
    //     // $msg = isset($info['msg']) ? $info['msg'] : 'success';
    //     // if (json_encode($data) == '[]' || empty($data)) {
            
    //     //     $info['code'] = 201;
    //     //     $info['msg'] = '没有数据..';
    //     //     $data = false;
    //     // }
    //     return response()->json(['code' => 200, 'msg' => 'success', 'data' => $data,'other'=>$other]);
    // }

    public function responseJson($data, $other = false, $msg = 'success', $code = 200) {
        // $code = isset($info['code']) ? $info['code'] : 200;
        // $msg = isset($info['msg']) ? $info['msg'] : 'success';
        if (json_encode($data) == '[]' || empty($data)) {
            $code = 201;
            $msg = '没有数据..';
            $data = false;
        }
        $responseData = [
            'code' => $code,
            'data' => $data,
            'msg' => $msg
        ];
        $other ? $responseData['other'] = $other : '' ;
        // return response()->json(['code' => $code, 'msg' =>  $msg, 'data' => $data,'other'=>$other]);
        return response()->json($responseData);
    }

}
