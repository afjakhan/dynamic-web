<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBankAndDocumentDetail extends Model
{
    use HasFactory;
	
	protected $fillable = [
	
		'vendor_id',
		'account_number',
		'ifsc_code',
		'bank_name',
		'beneficiary_name',
		'address_proof',
		'bank_passbook',
		'pan_card',
		'tax_invoice',
		
	];
}
