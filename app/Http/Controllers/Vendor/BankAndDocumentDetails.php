<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorBankAndDocumentDetail;
use App\Models\User;
use Validator;

class BankAndDocumentDetails extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		$rules = [
		
			'account_number'=>'required', 
			
			'ifsc_code'=>'required',
			
			'bank_name'=>'required',
			
			'beneficiary_name'=>'required'
		
		];
		$validation = Validator::make( $request->all(), $rules);
		
		if( $validation->fails() ){
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>$validation->errors() ], 200 );
			
		}
		
		if( VendorBankAndDocumentDetail::create( $request->all() ) ){
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Bank account details successfully saved' ], 200 );
			
		}
		else{
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>'Something went wrong' ], 200 );
			
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
	public function add_document( Request $request ){
		
		$rules = [

            'vendor_id'     	=> 'required',

            'address_proof'   	=> 'mimes:png,jpg,jpeg,svg|max:2048',
			
			'bank_passbook'		=> 'mimes:png,jpg,jpeg,svg|max:2048',
			
			'pan_card'			=> 'mimes:png,jpg,jpeg,svg|max:2048',
			
			'tax_invoice'		=> 'mimes:png,jpg,jpeg,svg|max:2048',

        ];

		$validation = Validator::make( $request->all(), $rules );

		if( $validation->fails() ){

			return response( [ 'error'=>true, 'status'=>400, 'msg'=>$validation->errors() ], 200 );

		}

		$address_proof = '';

		if( $request->address_proof ){

			$address_proof.= date('Y-m-d').'-'.time().'-address_proof.'.$request->address_proof->extension();

			$request->address_proof->move(public_path('assets/upload/document'), $address_proof);

		}
		$bank_passbook = '';

		if( $request->bank_passbook ){

			$bank_passbook.= date('Y-m-d').'-'.time().'-bank_passbook.'.$request->bank_passbook->extension();

			$request->bank_passbook->move(public_path('assets/upload/document'), $bank_passbook);

		}
		$pan_card = '';

		if( $request->pan_card ){

			$pan_card.= date('Y-m-d').'-'.time().'-pan_card.'.$request->pan_card->extension();

			$request->pan_card->move(public_path('assets/upload/document'), $pan_card);

		}
		$tax_invoice = '';

		if( $request->tax_invoice ){

			$tax_invoice.= date('Y-m-d').'-'.time().'-tax_invoice.'.$request->tax_invoice->extension();

			$request->tax_invoice->move(public_path('assets/upload/document'), $tax_invoice);

		}
		
		$documentdata['address_proof'] 	= asset('assets/upload/document/'.$address_proof);
		
		$documentdata['bank_passbook'] 	= asset('assets/upload/document/'.$bank_passbook);
		
		$documentdata['pan_card'] 		= asset('assets/upload/document/'.$pan_card);
		
		$documentdata['tax_invoice'] 	= asset('assets/upload/document/'.$tax_invoice);
		
		if(VendorBankAndDocumentDetail::where( 'vendor_id', $request->vendor_id )->update( $documentdata )){
			
			$userDetails = User::where( 'users.id', $request->vendor_id )->leftJoin( 'vendor_service_details', function($join){
				
				$join->on( 'users.id', 'vendor_service_details.vendor_id' );
				
			})->leftJoin( 'vendor_bank_and_document_details', function( $join ){
				
				$join->on( 'users.id', 'vendor_bank_and_document_details.vendor_id' );
				
			})->leftJoin( 'services', function( $join ){
				
				$join->on( 'services.id', 'vendor_service_details.service_id' );
				
			})->leftJoin( 'vendor_details', function( $join ){
				
				$join->on( 'users.id', 'vendor_details.vendor_id' );
				
			})->select( 'users.*', 'vendor_details.company_name', 'vendor_service_details.service_id', 'vendor_service_details.average_time', 'services.service_name', 'vendor_bank_and_document_details.account_number', 'vendor_bank_and_document_details.address_proof' )->first();
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Document updated uccessfully', 'userDetails'=>$userDetails], 200 );
			
		}
		else{
			
			return response( [ 'error'=>true, 'status'=>400, 'msg'=>'Failed to upload document' ], 200 );
			
		}

	}
}
