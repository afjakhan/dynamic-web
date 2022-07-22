<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorBankAndDocumentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_bank_and_document_details', function (Blueprint $table) {
			
            $table->id();
			
			$table->bigInteger( 'vendor_id' );
			
			$table->string( 'account_number', 20 );
			
			$table->string( 'ifsc_code', 20 );
			
			$table->string( 'bank_name', 100 );
			
			$table->string( 'beneficiary_name', 100  );
			
			$table->text( 'address_proof' )->nullable();
			
			$table->text( 'bank_passbook' )->nullable();
			
			$table->text( 'pan_card' )->nullable();
			
			$table->text( 'tax_invoice' )->nullable();
			
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
        Schema::dropIfExists('vendor_bank_and_document_details');
    }
}
