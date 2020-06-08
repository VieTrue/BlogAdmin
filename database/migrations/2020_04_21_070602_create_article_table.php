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
            $table->integer('hits')->default('0')->comment('点击');
            $table->tinyInteger('status')->index()->default('1')->comment('状态');
            $table->text('image')->nullable()->comment('缩略图');
            $table->text('content')->comment('内容');
            $table->text('attachment')->comment('附件');
            $table->timestamps();
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
