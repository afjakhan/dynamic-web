<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDetail extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'vendor_id',
        'company_name',
		'company_descripton',
		'contact_number',
		'company_logo',
		'contact_person_name',
		'numbers_of_employees',
		'country',
		'house_no',
        'street_name',
		'suburbs_name',
		'state',
		'pincode',
		'lat',
		'long',
		'facebook_url',
		'instagram_url',
		'youtube_url',
		'linkedin_url'
    ];
}
