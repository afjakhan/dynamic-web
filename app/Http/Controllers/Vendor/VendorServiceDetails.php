<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorServiceDetail;
use Validator;

class VendorServiceDetails extends Controller
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
		
			'service_id'=>'required',
			
			'vendor_id'=>'required'
		
		];
		
		$validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'error'=>true, 'status'=> 400, 'msg'=>$validation->errors() ] , 200 );

        }
		
		//$all_services = explode(',', rtrim(ltrim($request->service_id, '['), ']'));
		
		foreach( $request->service_id as $sid ){
			
			$service_data[ 'service_id' ]= $sid;
			
			$service_data[ 'vendor_id' ]= $request->vendor_id;
			
			$status = VendorServiceDetail::create( $service_data );
			
		}
		if( $status ){
			
			return response( [ 'error'=>false, 'msg'=>'Services details successfully saved' ], 200 );
		
		}
		else{
			
			return response( [ 'error'=>true, 'msg'=>'Services details failed to saved' ], 200 );
			
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
}
