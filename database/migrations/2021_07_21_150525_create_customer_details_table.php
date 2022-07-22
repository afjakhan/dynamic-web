<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_details', function (Blueprint $table) {
			
            $table->id();
			
			$table->bigInteger( 'user_id' );
			
			$table->text('profile_pic')->nullable();
			
			$table->string('phone_number', 15)->nullable();
			
			$table->string('communication_email', 120)->nullable();
			
			$table->string('fullname', 100)->nullable();
			
			$table->string('country', 100)->nullable();
			
			$table->string('street_no', 50)->nullable();
			
			$table->string('street_name', 100)->nullable();
			
			$table->string('suburb', 120)->nullable();
			
			$table->string('state', 100)->nullable();
			
			$table->integer('pincode')->nullable();
			
			$table->date('date_of_birth')->nullable();
			
			$table->string('gender', 15)->nullable();
			
			$table->text('facebook_url')->nullable();
			
			$table->text('instagram_url', 20)->nullable();
			
			$table->text('youtube_url', 20)->nullable();
			
            $table->timestamp('email_verified_at')->nullable();
			
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
        Schema::dropIfExists('customer_details');
    }
}
