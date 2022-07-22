<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class VendorProfile extends Controller
{
    //
	public function get_profile( $id ){
		
		$user = User::find( $id );
		
		if( $user ){
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'User found', 'user'=>$user ], 200 );
			
		}
		
		return response( [ 'error'=>true, 'status'=>400, 'msg'=>'User not found', 'user'=>[] ], 200 );
		
	}
	public function update_profile( Request $request ){
		
		$rules = [
		
			'username'=>'required|min:4',
			
			'email'=>'required',
			
			'fullname'=>'required',
			
			'phone_number'=>'required',
		
		];
		
		$validation = Validator::make( $request->all(), $rules );
		
		if( $validation->fails() ){
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>$validation->errors(), 'user'=>[] ], 200 );
			
		}
		$vendor = User::where( 'email', $request->email )->orWhere( 'username', $request->username )->first();
		
		if( $vendor && $vendor->id!=$request->id ){
			
			return response( [ 'error'=>true, 'status'=>400, 'vendor_id'=>$vendor->id, 'userExist'=>true ], 200 );
			
		}
		if( User::where( 'id', $request->id )->update( $request->all() ) ){
			
			return response( [ 'error'=>false, 'msg'=>'succ', 'status'=>200, 'user'=>$vendor ], 200 );
			
		}
		return response( [ 'error'=>true, 'msg'=>'err', 'status'=>200, 'user'=>[] ], 200 );
		
	}
	public function update_profile_pic( Request $request ){
		$rules = [

            'id'     			=> 'required',

            'profile_pic'   	=> 'mimes:png,jpg,jpeg,svg|max:2048',
			

        ];

		$validation = Validator::make( $request->all(), $rules );

		if( $validation->fails() ){

			return response( [ 'error'=>true, 'status'=>400, 'msg'=>$validation->errors() ], 200 );

		}

		$profile_pic = '';

		if( $request->profile_pic ){

			$profile_pic.= date('Y-m-d').'-'.time().'-profile-pic.'.$request->profile_pic->extension();

			$request->profile_pic->move(public_path('assets/upload/profile-pic'), $profile_pic);

		}
		if(User::where( 'id', $request->id )->update( ['profile_pic'=>asset('assets/upload/profile-pic/'.$profile_pic )] )){
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'success' ], 200 );
			
		}
		else{
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>'error' ], 200 );
			
		}
	}
}
