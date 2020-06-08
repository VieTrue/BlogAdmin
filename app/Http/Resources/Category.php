<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'slug' => $this->when($this->slug, $this->slug),
            // 'parent_id' => $this->parent_id,
            'desc' => $this->when($this->desc, $this->desc),
            'image' => $this->when($this->image, config('filesystems.disks.admin.url').'/'.$this->image),

        ];

    }


}

