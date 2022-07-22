<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerDashboard extends Controller
{
    //
	public function dashboard(){
		
		return response( ['dashboard'=>'This is dashboard'] );
		
	}
}
