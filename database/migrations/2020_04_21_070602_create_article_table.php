<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->default('')->comment('文章标题');
            $table->integer('catid')->index()->default('0')->comment('分类id');
            $table->text('desc')->nullable()->comment('描述');
            $table->integer('order')->default('100')->comment('排序');
            $table->tinyInteger('is_show')->index()->default('1')->comment('是否显示');
            $table->tinyInteger('is_comment')->default('1')->comment('开启评论');
            $table->integer('comments')->default('0')->comment('评论数');
            $table->integer('likes')->default('0')->comment('点赞数');
            $table->integer('views')->default('0')->comment('浏览量');
            $table->text('image')->nullable()->comment('缩略图');
            $table->text('content')->comment('内容');

            $table->tinyInteger('original')->default('1')->comment('是否原创');
            $table->text('originalurl')->comment('原文地址');

            $table->text('attachment')->comment('附件');
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
        Schema::dropIfExists('article');
    }
}
