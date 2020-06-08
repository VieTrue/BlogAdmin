<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    // protected static function booted()
    // {
    //     static::addGlobalScope(new AgeScope);
    // }

    /**
     * 重写模型的「booted」方法
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order','desc');
            $builder->latest('updated_at');
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

    public static function showinfo($id,$ip)
    {
        // $this->where('id',$id)->increment('views');
        $data = self::find($id);
        return $data;
    }

}
