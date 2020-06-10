<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    use SoftDeletes;
    use HasDateTimeFormatter;
    protected $table = 'article';

    protected $casts = [
        'is_show' => 'boolean',
        'is_comment' => 'boolean',
        'original' => 'boolean',
    ];

    /**
     * 重写模型的「booted」方法
     *
     * @return void
     */
    protected static function booted()
    {
        // 查询排序
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order','desc');
            $builder->latest('updated_at');
        });

        // 删除时执行
        static::deleting(function($model) {
            if ($model->trashed()) {
                $model->comment()->forceDelete();
                ArticleTag::where('article_id',$model->id)->delete();
            } else {
                $model->comment()->delete();
            }
        });
    }

    /**
     * 从写显示文章
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeIsShow($query)
    {
        return $query->where('is_show', 1);
    }

    /**
     * 关联分类模型
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'catid');
    }

    /**
     * 关联标签模型
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        // return $this->BelongsToMany(Tag::class, 'catid');
        return $this->belongsToMany(Tag::class, ArticleTag::class);
    }

    /**
     * 关联评论模型
     *
     * @return HasMany
     */
    public function comment(): HasMany
    {
        return $this->hasMany(ArticleComment::class, 'article_id')->latest();
    }

}
