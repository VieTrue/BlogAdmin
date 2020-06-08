<?php

namespace App\Http\Api;


use App\Http\Resources\CommentCollection;
use App\Models\ArticleComment as Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * 文章评论发布
     *
     * @param Request $request
     * @return json
     */
    public function setComment(Request $request)
    {
        $id = $request->id;
        $content = $request->content;
        $reply_id = $request->reply_id;
        $ip = $request->getClientIp();
        if (Article::where('id', $id)->value('is_comment') && !empty($content)) {
            $content = preg_replace('/^[( *)\#+(?= )]+|(?<=\n)[( *)\#+(?= )]+/','',$content);
            $data = [
                'article_id'=>$id,
                'content'=>$content,
                'reply_id'=>$reply_id,
                'ip'=>ip2long($ip)
            ];
            $res = Comment::create($data);
            Article::where('id', $id)->increment('comment');
            // if ($reply_id) {
            //     Comment::where('id', $reply_id)->increment('reply');
            // }
            $response = $this->responseJson($res);
        } else {
            $response = $this->responseJson(true, false, '未开启评论功能！！！');
        }

        return $response;
    }

    /**
     * 文章评论列表
     *
     * @param Request $request
     * @return json
     */
    public function getCommentList(Request $request)
    {
        $id = $request->id;
        // $ip = $request->getClientIp();
        $where = [
            'article_id' => $id,
            'reply_id' => 0
        ];
        $CommentData = Comment::where($where)->latest()->get();
        $data = new CommentCollection($CommentData);
        // $data = Comment::all();
        // $is_likes = $this->setOtherLikes($id, $ip);
        $response = $this->responseJson($data,false);
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
        } else {
            Article::where('id',$id)->increment('views');
            $article_other->insert($where);
        }
        return $data->is_likes ? true : false;
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
        } else {
            Article::where('id',$id)->increment('likes');
            $article_other->where($where)->increment('is_likes');
        }
        return $data->is_likes ? false : true;
    }

}