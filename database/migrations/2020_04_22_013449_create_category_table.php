<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->default('')->comment('名称');
            $table->string('slug')->index()->default('')->comment('标识');
            $table->integer('parent_id')->index()->default('0')->comment('父ID');
            $table->integer('order')->default('0')->comment('排序');
            $table->text('desc')->nullable()->comment('描述');
            $table->tinyInteger('status')->index()->default('1')->comment('状态');
            $table->text('image')->nullable()->comment('图片');
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
        Schema::dropIfExists('category');
    }
}
