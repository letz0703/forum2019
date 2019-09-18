<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->unsignedInteger('reputation')->default(0);
            $table->boolean('confirmed')->default(false);
            $table->boolean('isAdmin')->default(false);
            $table->string('confirmation_token', 25)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar_path')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
        DB::table('users')
          ->insert([
              'name'      => 'admin',
              'email'     => 'admin@example.com',
              'password'  => bcrypt('admin'),
              'isAdmin'   => true,
              'confirmed' => 1,
          ]);
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
