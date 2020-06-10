<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class ArticleComment extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'article_comment';
    protected $fillable = ['article_id', 'ip', 'likes', 'reply_id', 'content'];

    /**
     * 重写模型的「booted」方法
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->latest('updated_at');
        });

        // 删除时执行
        static::deleting(function($model) {
            // 删除关联的回复
            $model->trashed() ? $model->replyList()->forceDelete() : $model->replyList()->delete() ;
        });

    }

    /**
     * 关联回复
     *
     * @return HasMany
     */
    public function replyList(): HasMany
    {
        return $this->hasMany(ArticleComment::class, 'reply_id')->latest();
    }


}
