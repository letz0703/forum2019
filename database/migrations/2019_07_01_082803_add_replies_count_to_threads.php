<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRepliesCountToThreads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->integer('replies_count')->default(0);
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            //
            $table->dropColumn('replies_count');
        });
    }
}
