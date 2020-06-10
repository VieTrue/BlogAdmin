<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements Sortable
{
    use HasDateTimeFormatter,
        // ModelTree;
        ModelTree {
            allNodes as treeAllNodes;
            ModelTree::boot as treeBoot;
        }

    protected $table = 'category';


    /**
     * 重写模型的「booted」方法
     *
     * @return void
     */
    protected static function booted()
    {
        // 删除时执行
        static::deleting(function($model) {
            // 删除关联的评论
            $model->article()->forceDelete();
        });
    }

    /**
     * 关联文章模型
     *
     * @return HasMany
     */
    public function article(): HasMany
    {
        return $this->hasMany(Article::class, 'catid')->latest();
    }


    public static function getTitleValue($id)
    {

        return self::where('id', $id)->value('title');
    }

    /**
     * Get options for Select field in form.
     *
     * @param \Closure|null $closure
     *
     * @return array
     */
    public static function selectOptionsFind(\Closure $closure = null)
    {
        $options = (new static())->withQuery($closure)->buildSelectOptions();
        return collect($options)->all();
    }

}

