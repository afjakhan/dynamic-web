<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\VendorDetail;
use Hash;
use Validator;

class AuthController extends Controller
{
    public function customer_signup( Request $request ){
		
		$rules = [

            'username'          =>'required|min:4',

            'password'          =>'required|min:6',

            'email'  			=>'required|email'

        ];

        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'error'=>true, 'status'=> 400, 'msg'=>$validation->errors() ] , 200 );

        }

        if( !User::where( 'email', $request->email )->orWhere( 'username', $request->username )->first() ){

			$request->merge( [ 'user_role'=> 'customer' ] );
			
			$request[ 'password' ] = Hash::make( $request->password );
			
			$user = User::create( $request->all() );
			
			$token = $user->createToken( env( 'ACCESS_TOKEN' ) )->accessToken;
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Sign up successfull', 'user'=>$user, '_access_token'=>$token ], 200 );
            
            
        }
        else{

            return response( [ 'error'=>true, 'status'=>409, 'userExist'=>true ], 200 );

        }
		
	}
	public function customer_login( Request $request ){
		
		$rules = [

            'username'          =>'required',

            'password'          =>'required'

        ];

        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'error'=>true, 'status'=> 400, 'msg'=>$validation->errors() ] , 200 );

        }
		
		$user = User::where( 'username', $request->username )->orWhere( 'email', $request->username )->first();
			
		if( $user && Hash::check( $request->password, $user->password ) ){
			
			$token = $user->createToken( env( 'ACCESS_TOKEN' ) )->accessToken;
			
			Cookie::queue('_token', $token, 10);
			
			return response( [ 'error'=>false, 'status'=> 200, 'msg'=> 'Login successful', 'user'=>$user, '_access_token'=>$token ] , 200 );
			
		}
		
		return response( [ 'error'=>true, 'status'=> 400, 'msg'=>'Wrong username / email and password combination' ] , 200 );
		
	}
	public function vendor_signup( Request $request ){
		
		$rules = [

            'password'          =>'required|min:6',

            'email'  			=>'required|email',
			
			'username' 			=>'required|min:4'

        ];

        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'error'=>true, 'status'=> 400, 'msg'=>$validation->errors() ] , 200 );

        }

        if( !User::where( 'email', $request->email )->orWhere( 'username', $request->username )->first() ){
			
			$vendorData['user_role'] = 'vendor';
			
			$vendorData['user_status'] = 'pending';
			
			$vendorData['username'] = $request->username;
			
			$vendorData['email'] = $request->email;
			
			$vendorData['password'] = Hash::make( $request->password );;
			
			$user = User::create( $vendorData );
			
			$vendorDetails['vendor_id'] = $user->id;
			
			$vendorDetails['company_name'] = $request->company_name;
			
			$vendorDetails['contact_person_name'] = $request->contact_person_name;
			
			$vendorDetails['numbers_of_employees'] = $request->numbers_of_employees;
			
			$vendorDetails['street_name'] = $request->street_name;
			
			$vendorDetails['suburbs_name'] = $request->suburbs_name;
			
			$vendorDetails['state'] = $request->state;
			
			$vendorDetails['pincode'] = $request->pincode;
			
			$vendorDetails['lat'] = $request->lat;
			
			$vendorDetails['long'] = $request->long;
			
			$vendor_details = VendorDetail::create( $vendorDetails ); 
			
			$token = $user->createToken( env( 'ACCESS_TOKEN' ) )->accessToken;
			
			if( $user && $vendor_details ){
			
				return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Sign up successfull', 'user'=>$user, '_access_token'=>$token ], 200 );
			
			}
			else{
				
				return response( [ 'error'=>true, 'status'=>400, 'msg'=>'Sign up failed', 'user'=>[], '_access_token'=>'' ], 200 );
				
			}
            
            
        }
        else{

            return response( [ 'error'=>true, 'status'=>409, 'userExist'=>true ], 200 );

        }
		
	}
	public function vendor_login( Request $request ){
		
		$rules = [

            'email'          =>'required',

            'password'       =>'required'

        ];

        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'error'=>true, 'status'=> 400, 'msg'=>$validation->errors() ] , 200 );

        }
		
		$user = User::where( 'email', $request->email )->orWhere( 'username', $request->email )->first();
			
		if( $user && Hash::check( $request->password, $user->password ) ){
			
			$token = $user->createToken( env( 'ACCESS_TOKEN' ) )->accessToken;
			
			Cookie::queue('_token', $token, 10);
			
			$userDetails = User::where( 'email', $request->email )->orWhere( 'username', $request->email )->leftJoin( 'vendor_service_details', function($join){
				
				$join->on( 'users.id', 'vendor_service_details.vendor_id' );
				
			})->leftJoin( 'vendor_bank_and_document_details', function( $join ){
				
				$join->on( 'users.id', 'vendor_bank_and_document_details.vendor_id' );
				
			})->leftJoin( 'services', function( $join ){
				
				$join->on( 'services.id', 'vendor_service_details.service_id' );
				
			})->leftJoin( 'vendor_details', function( $join ){
				
				$join->on( 'users.id', 'vendor_details.vendor_id' );
				
			})->select( 'users.*', 'vendor_details.company_name', 'vendor_service_details.service_id', 'vendor_service_details.average_time', 'services.service_name', 'vendor_bank_and_document_details.account_number', 'vendor_bank_and_document_details.address_proof' )->first();
			
			return response( [ 'error'=>false, 'status'=> 200, 'msg'=> 'Login successful', 'userDetails'=>$userDetails, '_access_token'=>$token ] , 200 );
			
		}
		
		return response( [ 'error'=>true, 'status'=> 400, 'msg'=>'Wrong username / email and password combination' ] , 200 );
		
	}
	public function change_password( Request $request ){
		
		$rules = [
		
			'id'				=>'required',

            'old_password'      =>'required',

            'password'          =>'required',
			
			'confirm_password'  =>'required|same:password'

        ];
		
        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'error'=>true, 'status'=> 400, 'msg'=>$validation->errors() ] , 200 );

        }
		
		$data['password'] = Hash::make( $request->password );
		
		$user = User::where( 'id', $request->id )->first();
		
		if( Hash::check( $request->old_password, $user->password ) ){
		
			if( User::where( 'id', $request->id )->update( $data )){
				
				return response( [ 'error'=>false, 'oldPassword'=>true, 'status'=> 200, 'msg'=>'Password updated successfully' ] , 200 );
				
			}
			return response( [ 'error'=>true, 'oldPassword'=>true, 'status'=> 400, 'msg'=>'Sorry try again' ] , 200 );
			
		}
		
		return response( [ 'error'=>true, 'oldPassword'=>false, 'status'=> 400, 'msg'=>'Wrong old password' ] , 200 );
		
	}
	public function admin_login( Request $request ){
		
		
		$rules = [

            'username'          =>'required',

            'password'          =>'required'

        ];

        $validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'error'=>true, 'status'=> 400, 'msg'=>$validation->errors() ] , 200 );

        }
		
		$user = User::where( 'username', $request->username )->orWhere( 'email', $request->username )->first();
			
		if( $user && Hash::check( $request->password, $user->password ) ){
			
			$token = $user->createToken( env( 'ACCESS_TOKEN' ) )->accessToken;
			
			Cookie::queue('_token', $token, 10);
			
			return response( [ 'error'=>false, 'status'=> 200, 'msg'=> 'Login successful', 'user'=>$user, '_access_token'=>$token ] , 200 );
			
		}
		
		return response( [ 'error'=>true, 'status'=> 400, 'msg'=>'Wrong username / email and password combination', 'user'=>'', ] , 200 );
		
	}
	public function logout(){

        $tokens = auth()->user()->tokens;

        $logout_status = false;

        foreach( $tokens as $token ){

            $token->delete();

            $logout_status = true;

        }

        if( $logout_status ){
        
            return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Logout successful' ], 200 );

        }
        else{

            return response( [ 'error'=>true, 'status'=>400, 'msg'=>'Logout successful' ], 400 );

        }

    } 
}
