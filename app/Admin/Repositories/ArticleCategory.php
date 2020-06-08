<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\ArticleCategory as ArticleCategoryModel;

class ArticleCategory extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = ArticleCategoryModel::class;
}
