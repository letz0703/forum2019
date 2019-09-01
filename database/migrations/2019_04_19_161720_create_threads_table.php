<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('slug')->unique()->nullable();
            $table->unsignedInteger('channel_id');
            $table->BigInteger('best_reply_id')->unsigned()->nullable();
            $table->string('title');
            $table->text('body');
            $table->timestamps();
            
            $table->foreign('best_reply_id')
                  ->references('id')
                  ->on('replies')
                  ->onDelete('set null');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}