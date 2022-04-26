<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Driver\DriverAuthController;
use App\Http\Controllers\Api\Driver\TripController;
use App\Http\Controllers\Api\DriverRider\DriverRiderController;

Route::group([
    'middleware' => ['checkPassword','api'],
], function ($router) {

        //  driver
        Route::post('login'     ,  [DriverAuthController::class, 'login']);
        Route::post('current/location', [TripController::class, 'location']);
        
         //send message to login 
        Route::post('send/message', [App\Http\Controllers\Api\Messages\MessagesController::class, 'send_message_driver']);
        
        Route::post('reset/passowrd', [App\Http\Controllers\Api\Messages\MessagesController::class, 'send_message_driver_reset']);
        Route::post('reset/passowrd/change', [DriverAuthController::class, 'send_message_driver_reset']);

        Route::Group(['middleware' =>'auth.guard:driver-api'], function(){
            //driver Logout
            Route::post('logout', [DriverAuthController::class, 'logout']);
            
            // Rider modifications
            Route::post('modify/email', [DriverAuthController::class, 'email_update']);
            Route::post('modify/name', [DriverAuthController::class, 'name_update']);
            Route::post('modify/phone', [DriverAuthController::class, 'phone_update']);
            Route::post('modify/password', [DriverAuthController::class, 'password_update']);
            
            Route::post('data', [DriverAuthController::class, 'driver_data']);
            
            Route::post('show/trips/available', [TripController::class, 'show_intrnal_trip_to_driver']);
            Route::post('send/notification', [TripController::class, 'driver_send_notification']);
            Route::post('rider/picked', [TripController::class, 'rider_picked']);
            
            Route::post('city/request/response', [App\Http\Controllers\Api\Rider\CirtyTripController::class , 'driver_response']);
            Route::post('city/trips', [App\Http\Controllers\Api\Rider\CirtyTripController::class , 'show_city_trip_to_driver']);


            Route::post('request/response', [TripController::class, 'request']);
            Route::post('request/reject', [TripController::class, 'reject']);
            Route::post('available', [TripController::class, 'available']);
            Route::post('city/trip/start', [TripController::class, 'start_trip_city']);
            Route::post('city/trip/end', [TripController::class, 'end_trip_city']);
            
            Route::post('bond/{page?}', [App\Http\Controllers\Api\Driver\BoxDriverQueryController::class, 'get_bonds']);
            
            Route::post('send/message/update', [App\Http\Controllers\Api\Messages\MessagesController::class, 'send_message_driver_update']);
            
            Route::post('covenant/show', [App\Http\Controllers\Api\Driver\CovenantController::class, 'show_item']);
         
            //Route::post('request/end/trip', [TripController::class, 'trip_end']);
        
            Route::post('request/payment/trip', [DriverRiderController::class, 'trip_payment']);
            //Show my Trip
            Route::post('trips/{page?}', [App\Http\Controllers\Api\Driver\BoxDriverQueryController::class, 'trips']);
            Route::post('specific/trip', [App\Http\Controllers\Api\DriverRider\DriverRiderController::class, 'specific_trip']);
            
            Route::post('maintenance/add', [App\Http\Controllers\Api\Driver\MaintenanceController::class, 'add_maintenance']);
            Route::post('maintenance/show/{page?}', [App\Http\Controllers\Api\Driver\MaintenanceController::class, 'show_maintenance']);
        
    });
    
    
    
});
