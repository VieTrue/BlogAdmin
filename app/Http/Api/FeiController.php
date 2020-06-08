<?php

namespace App\Http\Api;

// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Routing\Controller;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;

// use App\Http\Resources\User as UserResource;
// use App\User;

// Route::get('/user', function () {
//     return UserResource::collection(User::all());
// });


class FeiController extends Controller
{
    public function index()
    {
        // dump(Article::where('is_status', '1')->get());
        // return UserResource::collection(User::all());
        return new ArticleCollection(Article::where('is_status', '1')->get());
        // return ArticleResources::collection(Article::all());
        // dump(Article::all());
        // $this->res($data);
        // return response()->json(['status' => false, 'msg' => '成功', 'data' => $data]);
        // exit('我是 FeiController@index');
    }
}