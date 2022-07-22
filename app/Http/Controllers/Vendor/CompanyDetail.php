<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorDetail;
use Validator;

class CompanyDetail extends Controller
{
    //
	public function get_company_details( $id ){
		
		$companyDetails = VendorDetail::where( 'vendor_id', $id )->first();
		
		if( $companyDetails ){
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'User found', 'companyDetails'=>$companyDetails ], 200 );
			
		}
		
		return response( [ 'error'=>true, 'status'=>400, 'msg'=>'User not found', 'companyDetails'=>[] ], 200 );
		
	}
	public function update_company_logo( Request $request ){
		
		$rules = [

            'id'     			=> 'required',

            'company_logo'   	=> 'mimes:png,jpg,jpeg,svg|max:2048',
			

        ];

		$validation = Validator::make( $request->all(), $rules );

		if( $validation->fails() ){

			return response( [ 'error'=>true, 'status'=>400, 'msg'=>$validation->errors() ], 200 );

		}

		$company_logo = '';

		if( $request->company_logo ){

			$company_logo.= date('Y-m-d').'-'.time().'-company-logo.'.$request->company_logo->extension();

			$request->company_logo->move(public_path('assets/upload/company-logo'), $company_logo);

		}
		if(VendorDetail::where( 'vendor_id', $request->id )->update( ['company_logo'=>asset('assets/upload/company-logo/'.$company_logo)] )){
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'success' ], 200 );
			
		}
		else{
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>'error' ], 200 );
			
		}
		
	}
	public function update_company_profile( Request $request ){
		
		$rules=[
		
			'company_name'=>'required',
			
			'contact_number'=>'required',
			
			'contact_person_name'=>'required',
			
			'numbers_of_employees'=>'required',
			
			'suburbs_name'=>'required',
			
			'state'=>'required',
			
			'pincode'=>'required',
			
			'country'=>'required',
		
		];
		
		$validation = Validator::make( $request->all(), $rules );
		
		if( $validation->fails() ){
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>$validation->errors() ], 200 );
			
		}
		if( VendorDetail::where( 'vendor_id', $request->vendor_id )->update( $request->all() ) ){
			
			return response( [ 'error'=>'succ', 'status'=>200, 'msg'=>'Updated successfully' ], 200 );
			
		}
		
		return response( [ 'error'=>'err', 'status'=>400, 'msg'=>'Sorry try again' ], 200 );
		
	}
}
