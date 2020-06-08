<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
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
            'title' => $this->title,
            'catid' => $this->catid,
            'category' => $this->CategoryToArray($this->category),
            'desc' => $this->desc,
            'order' => $this->order,
            'tags' => $this->TagsToArray($this->tags),
            'is_show' => $this->is_show,
            'is_comment' => $this->is_comment,
            'views' => $this->views,
            'likes' => $this->likes,
            'image' =>  $this->when($this->image, config('filesystems.disks.admin.url').'/'.$this->image),
            'content' => $this->content,
            'attachment' => $this->attachment,
            'original' => $this->original,
            'originalurl' => $this->originalurl,
            'updated_at' => date('Y-m-d H:i:s',strtotime($this->updated_at)),
            'comment' => $this->comment,
        ];

    }

    /**
     * 标签转换数组
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function TagsToArray($tags): array
    {
        $tag = [];
        foreach($tags as $k => $v) {
            $tag[$k] = $v['title'];
        }
        return $tag;
    }

    /**
     * 将资源转换成数组。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function CategoryToArray($category): array
    {
        $arr['id'] = $category['id'];
        $arr['title'] = $category['title'];
        $arr['slug'] = $category['slug'];
        return $arr;
    }


}

