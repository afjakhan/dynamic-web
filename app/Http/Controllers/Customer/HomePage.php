<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
Use Validator;

class HomePage extends Controller
{
   
    //
	public function explore_more(){
		
		$pendingVendors = User::where( 'user_role', 'vendor' )->where( 'user_status', 'accept' )->leftJoin( 'vendor_details', function( $join ){
			
			$join->on( 'users.id', 'vendor_details.vendor_id' );
			
		// })->leftJoin( 'vendor_service_details', function( $join ){
			
		// 	$join->on( 'users.id', 'vendor_service_details.vendor_id' );
			
		// })->leftJoin( 'services', function( $join ){
			
		// 	$join->on( 'vendor_service_details.service_id', 'services.id' );
			
		})->select( 'users.id','vendor_details.opening_time','vendor_details.closing_time','users.id as uid', 'users.fullname', 'users.username', 'users.profile_pic', 'vendor_details.house_no', 
		'vendor_details.street_name', 'vendor_details.company_name', 'vendor_details.state', 'vendor_details.country')->get();
		
		if( count( $pendingVendors ) > 0 ){
		
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Pending vendors found', 'pendingVendors'=>$pendingVendors ], 200 );
		
		}
		
		return response( [ 'error'=>true, 'status'=>400, 'msg'=>'No pending vendors found', 'pendingVendors'=>[] ], 200 );
		
	}

	public function service_details($id){
		
		$vendors = User::where( 'user_role', 'vendor' )->where( 'users.id', $id )->leftJoin( 'vendor_details', function( $join ){
			
			$join->on( 'users.id', 'vendor_details.vendor_id' );
			
		})->leftJoin( 'vendor_service_details', function( $join ){
			
			$join->on( 'users.id', 'vendor_service_details.vendor_id' );
			
		})->leftJoin( 'services', function( $join ){
			
			$join->on( 'vendor_service_details.service_id', 'services.id' );
			
		})->select('vendor_details.company_name','vendor_service_details.short_description','vendor_service_details.long_description','vendor_details.opening_time','vendor_details.closing_time','users.profile_pic'
		)->first();
		
		
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Pending vendors found', 'vendors'=>$vendors ], 200 );
		
		
		
	}	
}
