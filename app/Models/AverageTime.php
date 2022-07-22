<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AverageTime extends Model
{
    use HasFactory;
	
	protected $fillable= [
	
		'service_id',
		'average_service_time'
	
	];
}
