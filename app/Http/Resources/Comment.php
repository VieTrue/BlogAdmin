<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    /**
     * 将资源转换成数组。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->ip,
            'reply_id' => $this->reply_id,
            'likes' => $this->likes,
            'content' => $this->content,
            'reply' => '',
            'isReply' => true,
            'replyList' => $this->ToreplyList($this->replyList),
            'updated_at' => date('Y-m-d H:i:s',strtotime($this->updated_at)),
        ];

    }

    public function ToreplyList($replyList)
    {
        $data = [];
        foreach ($replyList->toArray() as $key => $value) {
            $data[$key] = $value;
            $keydata = &$data[$key];
            $keydata['name'] = $value['ip'];
            unset($keydata['article_id'],$keydata['ip'],$keydata['reply'],$keydata['created_at'],$keydata['deleted_at']);
        }
        return $data;
    }

}

