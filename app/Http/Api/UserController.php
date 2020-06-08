<?php

namespace App\Http\Api;


use App\Http\Resources\ArticleCollection;
use Illuminate\Support\Facades\DB;
// use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getInfo()
    {
        
        $users = DB::table('admin_users')->find(1);
        $data['name'] = $users->name;
        $data['avatar'] = config('filesystems.disks.admin.url').'/'.$users->avatar;
        $data['info'] = 'php是世界上最好的语言！';
        $response = $this->responseJson($data);
        // dump($response);
        // $id = $request->id;
        // $data = new ArticleR(Article::find($id));
        // $response = $this->responseJson($data);
        return $response;
    }


}