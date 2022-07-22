<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
			
            $table->id();
			
            $table->string('user_role', 20);
			
			$table->string( 'user_status', 15 )->default( 'active' );
			
			$table->string('username', 100)->unique()->nullable();
			
			$table->string('fullname', 100)->nullable();
			
			$table->date('dob')->nullable();
			
			$table->string('gender')->nullable();
			
			$table->string('phone_number', 100)->nullable();
			
			$table->string('email', 120)->unique();
			
			$table->string('password', 255);
			
			$table->text('profile_pic')->nullable();
			
            $table->rememberToken();
			
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
        Schema::dropIfExists('users');
    }
}
