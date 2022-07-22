<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorServiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_service_details', function (Blueprint $table) {
			
            $table->id();
			
			$table->bigInteger( 'vendor_id' );
			
			$table->tinyInteger( 'service_id' );
			
			$table->tinyInteger( 'average_time' )->nullable();
			
			$table->string( 'time_slot', 255 )->nullable();
			
			$table->double( 'charge' )->nullable();
			
			$table->text( 'short_description' )->nullable();
			
			$table->text( 'long_description' )->nullable();
			
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
        Schema::dropIfExists('vendor_service_details');
    }
}
