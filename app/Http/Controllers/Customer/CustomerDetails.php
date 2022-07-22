<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerDetail;
Use Validator;

class CustomerDetails extends Controller
{
   
    public function save_customer_details(Request $request)
    {
        //
		$rules = [
		
			'phone_number'=>'required',
			
			'communication_email'=>'email',
			
			'fullname'=>'required',
			
			'street_no'=>'required',
			
			'street_name'=>'required',
			
			'suburb'=>'required',
			
			'state'=>'required',
			
			'pincode'=>'required|numeric',
		
		];
		
		$validation = Validator::make( $request->all(), $rules );
		
		if( $validation->fails() ){
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>$validation->errors() ], 200 );
			
		}
		if( CustomerDetail::create( $request->all() ) ){
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'User details successfully saved' ], 200 );
			
		}
		return response( [ 'error'=>true, 'status'=>400, 'msg'=>'Failed to save user data' ], 200 );
    }
	
}
