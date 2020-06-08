<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasDateTimeFormatter;
    protected $table = 'tags';
    protected $fillable = ['title'];


    /**
     * 关联标签模型
     *
     * @return BelongsToMany
     */
    public function article(): BelongsToMany
    {
        // return $this->BelongsToMany(Tag::class, 'catid');
        return $this->belongsToMany(Article::class, ArticleTag::class);
    }


    public static function selectOptionsTags()
    {
        $options = self::pluck('title','id');
        // foreach ($options as $key => $val) {
        //     $name[$val] = $val;
        // }
        return $options;
    }

}
