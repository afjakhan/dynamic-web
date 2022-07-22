<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AverageTime;
use App\Models\VendorServiceDetail;
use Validator;

class AverageServiceTime extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		if( $average_time = AverageTime::all() ){
			
			return response( [ 'error'=>false, 'status'=>200, 'msg'=>'Average servicetime found', 'service_time'=>$average_time ], 200 );
			
		}
		return response( [ 'error'=>true, 'status'=>409, 'msg'=>'No average servicetime found' ], 200 );
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
	public function set_average_service_time( Request $request ){
		
		$rules = [
		
			'average_time'=>'required',
		
		];
		$validation = Validator::make( $request->all(), $rules );

        if( $validation->fails() ){

            return response( [ 'error'=>true, 'status'=> 400, 'msg'=>$validation->errors() ] , 200 );

        }
		
		$data['average_time'] = $request->average_time;
		
		if( VendorServiceDetail::where( 'vendor_id', $request->vendor_id )->update( $data ) ){
		
			return response( [ 'error'=>false, 'status'=> 200, 'msg'=>'Successfully saved', 'data'=>$request->all() ], 200 );
			
		}
		else{
			
			return response( [ 'error'=>true, 'status'=> 400, 'msg'=>'Failed to saved' ], 200 );
			
		}
		
	}
}
