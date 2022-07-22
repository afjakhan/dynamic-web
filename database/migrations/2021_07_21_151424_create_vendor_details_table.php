<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_details', function (Blueprint $table) {
			
            $table->id();
			
			$table->bigInteger( 'vendor_id' );
			
			$table->string( 'company_name', 100 )->nullable();
			
			$table->text( 'company_description' )->nullable();
			
			$table->string( 'contact_number' )->nullable();
			
			$table->string( 'opening_time' )->nullable();
			
			$table->string( 'closing_time' )->nullable();
			
			$table->text( 'company_logo' )->nullable();
			
			$table->string( 'contact_person_name', 100 )->nullable();
			
			$table->integer( 'numbers_of_employees' )->nullable();
			
			$table->string( 'country', 100 )->nullable();
			
			$table->string( 'house_no', 50 )->nullable();
			
			$table->string( 'street_name', 100 )->nullable();
			
			$table->string( 'suburbs_name', 100 )->nullable();
			
			$table->string( 'state', 100 )->nullable();
			
			$table->integer( 'pincode' )->nullable();
			
			$table->double( 'lat' );
			
			$table->double( 'long' );
			
			$table->text( 'facebook_url' )->nullable();
			
			$table->text( 'instagram_url' )->nullable();
			
			$table->text( 'youtube_url' )->nullable();
			
			$table->text( 'linkedin_url' )->nullable();
			
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
        Schema::dropIfExists('vendor_details');
    }
}
