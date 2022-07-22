<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class AdminVendorController extends Controller
{
    //
	public function all_pending_vendors(){
		
		$pendingVendors = User::where( 'user_role', 'vendor' )->where( 'user_status', 'pending' )->leftJoin( 'vendor_details', function( $join ){
			
			$join->on( 'users.id', 'vendor_details.vendor_id' );
			
		})->leftJoin( 'vendor_service_details', function( $join ){
			
			$join->on( 'users.id', 'vendor_service_details.vendor_id' );
			
		})->leftJoin( 'services', function( $join ){
			
			$join->on( 'vendor_service_details.service_id', 'services.id' );
			
		})->leftJoin( 'vendor_bank_and_document_details', function( $join ){
			
			$join->on( 'vendor_bank_and_document_details.vendor_id', 'users.id' );
			
		})->select( 'users.id as uid', 'users.fullname', 'users.username', 'users.profile_pic', 'vendor_details.house_no', 
		'vendor_details.street_name', 'vendor_details.suburbs_name', 'vendor_details.state', 'vendor_details.country', 'vendor_service_details.service_id', 'services.service_name', 
		'vendor_bank_and_document_details.account_number', 'vendor_bank_and_document_details.ifsc_code', 'vendor_bank_and_document_details.bank_name',
		'vendor_bank_and_document_details.address_proof', 'vendor_bank_and_document_details.bank_passbook', 'vendor_bank_and_document_details.pan_card', 'vendor_bank_and_document_details.tax_invoice' )->get();
		
		if( count( $pendingVendors ) > 0 ){
		
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Pending vendors found', 'pendingVendors'=>$pendingVendors ], 200 );
		
		}
		
		return response( [ 'error'=>true, 'status'=>400, 'msg'=>'No pending vendors found', 'pendingVendors'=>[] ], 200 );
		
	}
	public function update_vendor_status( Request $request ){
		
		$rules = [
		
			'id'=>'required',
			
			'vendor_status'=>'required'
		
		];
		
		$validation = Validator::make( $request->all(), $rules );
		
		if( $validation->fails() ){
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>$validation->errors() ], 200 );
			
		}
		
		if( User::where( 'id', $request->id )->update( [ 'user_status'=>$request->vendor_status ] ) ){
			
			$pendingVendors = User::where( 'user_role', 'vendor' )->where( 'user_status', 'pending' )->leftJoin( 'vendor_details', function( $join ){
			
			$join->on( 'users.id', 'vendor_details.vendor_id' );
			
		})->leftJoin( 'vendor_service_details', function( $join ){
			
			$join->on( 'users.id', 'vendor_service_details.vendor_id' );
			
		})->leftJoin( 'services', function( $join ){
			
			$join->on( 'vendor_service_details.service_id', 'services.id' );
			
		})->leftJoin( 'vendor_bank_and_document_details', function( $join ){
			
			$join->on( 'vendor_bank_and_document_details.vendor_id', 'users.id' );
			
		})->select( 'users.id as uid', 'users.fullname', 'users.username', 'users.profile_pic', 'vendor_details.house_no', 
		'vendor_details.street_name', 'vendor_details.suburbs_name', 'vendor_details.state', 'vendor_details.country', 'vendor_service_details.service_id', 'services.service_name', 
		'vendor_bank_and_document_details.account_number', 'vendor_bank_and_document_details.ifsc_code', 'vendor_bank_and_document_details.bank_name',
		'vendor_bank_and_document_details.address_proof', 'vendor_bank_and_document_details.bank_passbook', 'vendor_bank_and_document_details.pan_card', 'vendor_bank_and_document_details.tax_invoice' )->get();
		
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Vendor successfully '.$request->vendor_status, 'pendingVendors'=>$pendingVendors ], 200 );
			
		}
		return response( [ 'error'=>true, 'status'=>200, 'msg'=>'Vendor failed to '.$request->vendor_status ], 200 );
		
	}
}
