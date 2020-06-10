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
     * 重写模型的「booted」方法
     *
     * @return void
     */
    protected static function booted()
    {
        // 删除时执行
        static::deleting(function($model) {
            // 删除关联的中间表记录
            ArticleTag::where('tag_id',$model->id)->delete();
        });
    }

    /**
     * 关联标签模型
     *
     * @return BelongsToMany
     */
    public function article(): BelongsToMany
    {
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
