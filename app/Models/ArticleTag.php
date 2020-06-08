<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Pivot
{
    use HasDateTimeFormatter;
    protected $table = 'article_tags';
    public $timestamps = false;

}
