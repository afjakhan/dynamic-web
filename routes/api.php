<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\CustomerDashboard;
use App\Http\Controllers\Customer\CustomerDetails;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Service\AverageServiceTime;
use App\Http\Controllers\Vendor\VendorServiceDetails;
use App\Http\Controllers\Vendor\BankAndDocumentDetails;
use App\Http\Controllers\Vendor\VendorProfile;
use App\Http\Controllers\Vendor\CompanyDetail;
use App\Http\Controllers\Admin\AdminVendorController;

use App\Http\Controllers\Customer\HomePage;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post( '/customer/signup', [ AuthController::class, 'customer_signup' ] );
Route::post( '/customer/login', [ AuthController::class, 'customer_login' ] );

Route::post( '/vendor/signup', [ AuthController::class, 'vendor_signup' ] );
Route::post( '/vendor/login', [ AuthController::class, 'vendor_login' ] );

Route::post( '/admin/login', [ AuthController::class, 'admin_login' ] );

Route::get( '/service/all-services', [ ServiceController::class, 'index' ] );

Route::middleware( [ 'auth:api' ] )->group( function(){

    Route::apiResources([

        '/vendor/signup-step-two'=>VendorServiceDetails::class,
		
		'/vendor/bank-account-details'=>BankAndDocumentDetails::class,
		
		'/vendor/average-service-time'=>AverageServiceTime::class,

    ]);
	
	Route::get( '/customer/dashboard', [ CustomerDashboard::class, 'dashboard' ] );
	
	Route::post( '/customer/save-customer-details', [ CustomerDetails::class, 'save_customer_details' ] );
	
	Route::post( '/vendor/average-service-time', [ AverageServiceTime::class, 'set_average_service_time' ] );
	
	Route::post( '/vendor/add-bank-account-details', [ BankAndDocumentDetails::class, 'add_document' ] );
	
	Route::get( '/vendor/get-vendor-profile/{id}', [ VendorProfile::class, 'get_profile' ] );
	
	Route::post( '/vendor/update-vendor-profile', [ VendorProfile::class, 'update_profile' ] );
	
	Route::post( '/vendor/add-profile-pic', [ VendorProfile::class, 'update_profile_pic' ] );
	
	Route::get( '/vendor/get-company-profile/{id}', [ CompanyDetail::class, 'get_company_details' ] );
	
	Route::post( '/vendor/add-company-logo', [ CompanyDetail::class, 'update_company_logo' ] );
	
	Route::post( '/vendor/update-company-profile', [ CompanyDetail::class, 'update_company_profile' ] );
	
	Route::get( '/vendor/get-all-vendor-services/{id}', [ ServiceController::class, 'all_vendor_services' ] );
	
	Route::get( '/vendor/get-service-details/{id}/{vendor_id}', [ ServiceController::class, 'get_services_details' ] );
	
	Route::post( '/vendor/add-vendor-services', [ ServiceController::class, 'add_vendor_services' ] );
	
	Route::post( '/vendor/update-service-details', [ ServiceController::class, 'update_vendor_services' ] );
	
	Route::get( '/vendor/delete-vendor-services/{service_id}/{vendor_id}', [ ServiceController::class, 'delete_vendor_services' ] );
	
	Route::get( 'admin/pending-vendors', [ AdminVendorController::class, 'all_pending_vendors' ] );
	
	Route::post( '/admin/update-vendor-status', [ AdminVendorController::class, 'update_vendor_status' ] );
	
	Route::post( '/change-password', [ AuthController::class, 'change_password' ] );
	
    Route::post( '/logout', [ AuthController::class, 'logout' ] );
   
});
	 #-------------------------------------------------------------------------------
    Route::get( 'customer/explore_more', [HomePage::class, 'explore_more' ] );
    Route::get( 'customer/service_details/{id}', [HomePage::class, 'service_details' ] );