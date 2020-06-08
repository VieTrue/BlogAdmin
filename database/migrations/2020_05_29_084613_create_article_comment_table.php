<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->index()->default('0')->comment('文章id');
            $table->bigInteger('ip')->index()->default('0')->comment('ip地址');
            $table->integer('likes')->default('0')->comment('点赞次数');
            $table->integer('reply')->index()->default('0')->comment('回复评论id');
            $table->text('content')->comment('评论内容');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_comment');
    }
}
