<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleOtherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_other', function (Blueprint $table) {
            $table->integer('article_id');
            $table->bigInteger('ip')->default('0')->comment('ip地址');
            $table->tinyInteger('is_likes')->default('0')->comment('是否点赞');
            $table->integer('frequency')->default('0')->comment('访问次数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_views');
    }
}
