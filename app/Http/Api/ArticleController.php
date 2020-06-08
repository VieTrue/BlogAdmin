<?php

namespace App\Http\Api;


use App\Http\Resources\ArticleCollection;
use App\Http\Resources\Article as ArticleR;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * 文章列表
     *
     * @param Request $request
     * @return json
     */
    public function getList(Request $request)
    {
        $limit = $request->limit;
        $catid = $request->catid;
        $ArticleData = Article::when($catid, function ($query, $catid) {
            return $query->where('catid', $catid);
        })
        ->isShow()
        ->simplePaginate($limit);

        $data = new ArticleCollection($ArticleData);
        $response = $this->responseJson($data);
        return $response;
    }

    /**
     * 文章标签列表
     *
     * @param Request $request
     * @return json
     */
    public function getTagList(Request $request)
    {
        $tag = $request->tag;
        $limit = $request->limit;
        $tags = Tag::where('title',$tag)
                    ->first()
                    ->article()
                    ->isShow()
                    ->simplePaginate($limit);

        $data = new ArticleCollection($tags);
        $response = $this->responseJson($data);
        return $response;
    }

    /**
     * 文章搜索列表
     *
     * @param Request $request
     * @return json
     */
    public function getSearchList(Request $request)
    {
        $keywords = trim($request->keywords);
        $limit = $request->limit;

        // $tags = Tag::where('title',$tag)->first();
        $ArticleData = Article::isShow()
                                ->where(function($query) use ($keywords) {
                                    $query->where('title', 'like', '%'.$keywords.'%');
                                    $query->orWhere('content', 'like', '%'.$keywords.'%');
                                })
                                ->simplePaginate($limit);
        $data = new ArticleCollection($ArticleData);
        $response = $this->responseJson($data);
        return $response;
    }

    /**
     * 文章详情
     *
     * @param Request $request
     * @return json
     */
    public function getInfo(Request $request)
    {
        $ip = $request->getClientIp();
        $id = $request->id;
        if (Article::where('id', $id)->exists()) {
            $this->setOtherViews($id, $ip);
            $data = new ArticleR(Article::find($id));
            $response = $this->responseJson($data);
        } else {
            $response = $this->responseJson(true,false,'error','404');
        }
        // $response = $this->responseJson($data,['is_likes'=>$is_likes]);
        return $response;
    }

    /**
     * 文章点赞
     *
     * @param Request $request
     * @return json
     */
    public function spotLikes(Request $request)
    {
        $id = $request->id;
        $ip = $request->getClientIp();
        $is_likes = $this->setOtherLikes($id, $ip);
        $response = $this->responseJson(true,['is_likes'=>$is_likes],'成功',200);
        return $response;
    }

    /**
     * 根据ip记录浏览量
     *
     * @param [int] $id 文章id
     * @param [string] $ip 客户端ip
     * @return boolean
     */
    public function setOtherViews($id, $ip) : bool
    {
        $article_other = DB::table('article_other');
        $where = ['article_id' => $id, 'ip' => ip2long($ip)];
        $data = $article_other->where($where)->first();
        if ($data) {
            $article_other->where($where)->increment('frequency');
            // return $data->is_likes ? true : false;
        } else {
            Article::where('id',$id)->increment('views');
            $article_other->insert($where);
        }
        return false;
    }

    /**
     * 点赞处理
     *
     * @param [int] $id 文章id
     * @param [string] $ip 客户端ip
     * @return boolean
     */
    public function setOtherLikes($id, $ip) : bool
    {
        $article_other = DB::table('article_other');
        $where = ['article_id' => $id, 'ip' => ip2long($ip)];
        $data = $article_other->where($where)->first();
        if ($data->is_likes) {
            Article::where('id',$id)->decrement('likes');
            $article_other->where($where)->decrement('is_likes');
            // return $data->is_likes ? false : true;
        } else {
            Article::where('id',$id)->increment('likes');
            $article_other->where($where)->increment('is_likes');
            // return $data->is_likes ? false : true;
        }
        return true;
    }

}