<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\VendorServiceDetail;
use Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$services = Service::all();
		
		if( $services ){
			
			return response( [ 'error'=>false, 'status'=>200 ,'msg'=>'All services', 'services'=>$services ], 200);
			
		}
		else{
			
			return response( [ 'error'=>true, 'status'=>400 ,'msg'=>'No service found', 'services'=>[] ], 200);
			
		}
		
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
	public function all_vendor_services( $vendor_id ){
		
		$all_vendor_ervices = VendorServiceDetail::where( 'vendor_id', $vendor_id )->leftJoin( 'services', function( $join ){
			
			$join->on( 'vendor_service_details.service_id', 'services.id' );
			
		})->select( 'vendor_service_details.*', 'services.service_name' )->get();
		
		if( $all_vendor_ervices ){
			
			return response( [ 'error'=>false, 'status'=>200 ,'msg'=>'All vendor services', 'allVendorServices'=>$all_vendor_ervices ], 200);
			
		}
		
		return response( [ 'error'=>true, 'status'=>200 ,'msg'=>'No vendor services found', 'allVendorServices'=>[] ], 200);
		
	}
	public function delete_vendor_services( $vendor_id, $id ){
		
		$all_vendor_service = VendorServiceDetail::where( 'vendor_id', $vendor_id )->get();
		
		$all_vendor_ervices = VendorServiceDetail::where( 'vendor_id', $vendor_id )->leftJoin( 'services', function( $join ){
				
			$join->on( 'vendor_service_details.service_id', 'services.id' );
			
		})->select( 'vendor_service_details.*', 'services.service_name' )->get();
		
		if( count($all_vendor_service)>1 ){
		
			$delete_status = VendorServiceDetail::where( 'vendor_id', $vendor_id )->where( 'id', $id )->delete();
			
			if( $delete_status ){
				
				$all_vendor_ervices_after_del = VendorServiceDetail::where( 'vendor_id', $vendor_id )->leftJoin( 'services', function( $join ){
				
					$join->on( 'vendor_service_details.service_id', 'services.id' );
					
				})->select( 'vendor_service_details.*', 'services.service_name' )->get();
				
				return response( [ 'error'=>'succ', 'status'=>200 ,'msg'=>'Service deleted successfully', 'allVendorServices'=>$all_vendor_ervices_after_del ], 200);
				
			}
			return response( [ 'error'=>'err', 'status'=>400 ,'msg'=>'Failed to delete service', 'allVendorServices'=>$all_vendor_ervices ], 200);
		
		}
		else{
		
			return response( [ 'error'=>'delerror', 'status'=>400 ,'msg'=>'You have to atleat one service', 'allVendorServices'=>$all_vendor_ervices ], 200);
		
		}
		
	}
	public function add_vendor_services( Request $request ){
		
		$rules = [
		
			'vendor_id'=>'required',
			
			'service_id'=>'required',
		
		];
		
		$validation = Validator::make( $request->all(), $rules );
		
		if( $validation->fails() ){
			
			return response( [ 'error'=>true, 'status'=>400, 'serviceExist'=>false, 'msg'=>$validation->errors(), 'allVendorServices'=>$all_vendor_ervices ], 200);
			
		}
		
		$all_vendor_ervices = VendorServiceDetail::where( 'vendor_id', $request->vendor_id )->leftJoin( 'services', function( $join ){
			
			$join->on( 'vendor_service_details.service_id', 'services.id' );
			
		})->select( 'vendor_service_details.*', 'services.service_name' )->get();
		
		if( !VendorServiceDetail::where( 'vendor_id', $request->vendor_id )->where( 'service_id', $request->service_id )->first() ){
			
			if( VendorServiceDetail::create( $request->all() ) ){
				
				$all_vendor_ervices_after_add = VendorServiceDetail::where( 'vendor_id', $request->vendor_id )->leftJoin( 'services', function( $join ){
			
					$join->on( 'vendor_service_details.service_id', 'services.id' );
					
				})->select( 'vendor_service_details.*', 'services.service_name' )->get();
				
				return response( [ 'error'=>'success', 'status'=>200, 'serviceExist'=>false, 'msg'=>'Service added successfully', 'allVendorServices'=>$all_vendor_ervices_after_add ], 200);
				
			}
			return response( [ 'error'=>'error', 'status'=>400, 'serviceExist'=>false, 'msg'=>'Failed to add services', 'allVendorServices'=>$all_vendor_ervices ], 200);
		}
		return response( [ 'error'=>true, 'status'=>400, 'serviceExist'=>true, 'msg'=>'Failed to add services', 'allVendorServices'=>$all_vendor_ervices ], 200);
	}
	
	public function get_services_details( $id, $vendor_id ){
		
		$all_vendor_ervices_after_add = VendorServiceDetail::where( 'vendor_service_details.vendor_id', $vendor_id )->where( 'vendor_service_details.id', $id )->leftJoin( 'services', function( $join ){
			
			$join->on( 'vendor_service_details.service_id', 'services.id' );
			
		})->select( 'vendor_service_details.*', 'services.service_name' )->first();
		
		if( $all_vendor_ervices_after_add ){
			
			return response( [ 'error'=>'success', 'status'=>200, 'serviceExist'=>false, 'msg'=>'Service added successfully', 'serviceDetails'=>$all_vendor_ervices_after_add ], 200);
			
		}
		
		return response( [ 'error'=>'error', 'status'=>400, 'serviceExist'=>false, 'msg'=>'Failed to add services', 'serviceDetails'=>'' ], 200);
		
	}
	public function update_vendor_services( Request $request ){
		
		$rules = [
		
			'vendor_id'=>'required',
			
			'id'=>'required',
		
			'average_time'=>'required',
			
			'charge'=>'required',
			
			'short_description'=>'required', 
			
			'long_description'=>'required',
			
			'time_slot'=>'required',
		
		];
		
		
		$validation = Validator::make( $request->all(), $rules );
		
		if( $validation->fails() ){
			
			return response( [ 'error'=>true, 'status'=>400, 'serviceExist'=>false, 'msg'=>$validation->errors() ], 200);
			
		}
		
		$data[ 'average_time' ] = $request->average_time;
		
		$data[ 'charge' ] = $request->charge;
		
		$data[ 'short_description' ] = $request->short_description;
		
		$data[ 'long_description' ] = $request->long_description;
		
		$data[ 'time_slot' ] = rtrim( $request->time_slot, '|' );
		
		if( VendorServiceDetail::where( 'id', $request->id )->where( 'vendor_id', $request->vendor_id )->update( $data ) ){
			
			return response( [ 'error'=>false, 'status'=>400, 'msg'=>'succ' ], 200);
			
		}
		
		return response( [ 'error'=>true, 'status'=>400, 'msg'=>'err' ], 200);
		
	}
}
