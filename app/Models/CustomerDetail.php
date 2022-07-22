<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    use HasFactory;
	
	protected $fillable = [
	
		'user_id',
		'profile_pic',
		'phone_number'
		'communication_email',
		'fullname',
		'street_no',
		'street_name',
		'suburb',
		'state',
		'pincode',
	
	];
}
