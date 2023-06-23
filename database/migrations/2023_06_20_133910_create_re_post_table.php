<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_post', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repost_id');    //リツイートするほうのid
            $table->unsignedBigInteger('post_id');   //引用リツイートされる方のid
            $table->timestamps();
            
            // 外部制約キー
            $table->foreign('post_id')->references('id')->on('microposts')->onDelete('cascade');
            
            //post_idとrepost_idの重複を許さない
            $table->unique(['post_id', 'repost_id']);
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('re_post');
    }
};
