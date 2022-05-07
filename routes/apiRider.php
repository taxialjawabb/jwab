<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Rider\RiderAuthController;
use App\Http\Controllers\Api\Rider\TripController;
use App\Http\Controllers\Api\Rider\PaymentController;
use App\Http\Controllers\Api\Rider\RiderMessageController;

Route::group([
    'middleware' => ['checkPassword','api'],
], function ($router) {

    // Register and login rider
    Route::post('register'  ,          [RiderAuthController::class, 'register']);
    Route::post('login'     ,  [RiderAuthController::class, 'login']);
    
    //send message to login or register
    Route::post('send/message', [App\Http\Controllers\Api\Messages\MessagesController::class, 'send_message']);

    Route::post('reset/passowrd', [App\Http\Controllers\Api\Messages\MessagesController::class, 'send_message_reset']);
    Route::post('reset/passowrd/change', [RiderAuthController::class, 'send_message_reset']);

    Route::Group(['middleware' =>'auth.guard:rider-api'], function(){
        //Rider Logout
        Route::post('logout', [RiderAuthController::class, 'logout']);

        // Rider modifications
        Route::post('modify/email', [RiderAuthController::class, 'email_update']);
        Route::post('modify/name', [RiderAuthController::class, 'name_update']);
        Route::post('modify/phone', [RiderAuthController::class, 'phone_update']);
        Route::post('modify/password', [RiderAuthController::class, 'password_update']);    
        Route::post('modify/birth/date', [RiderAuthController::class, 'birth_date_update']);    
        Route::post('modify/gender', [RiderAuthController::class, 'gender_update']);    
        
        Route::post('update/data', [RiderAuthController::class, 'rider_update']);    
        
        // Rider Trip 
        Route::post('request', [TripController::class, 'request']);
        Route::post('request/cancel', [TripController::class, 'cancel']);
        Route::post('request/cancel/request/time', [TripController::class, 'cancel_reqest_time']);
        Route::post('response/driver', [TripController::class, 'start']);
        Route::post('trip/state', [TripController::class, 'get_trip_data']);

        
        // send message
        Route::post('send/message/update', [App\Http\Controllers\Api\Messages\MessagesController::class, 'send_message_update']);
        
        //Vechile category
        Route::post('vechile/category', [TripController::class, 'category']);
        
        //city trip 
        Route::post('city/vechile/category', [App\Http\Controllers\Api\Rider\CirtyTripController::class, 'city_category']);
        Route::post('city/trip/reservation', [App\Http\Controllers\Api\Rider\CirtyTripController::class, 'city_request']);
        Route::post('city/trip/canceled', [App\Http\Controllers\Api\Rider\CirtyTripController::class, 'rider_canceled_trip']);
        
        // rate
        Route::post('trip/rate', [App\Http\Controllers\Api\Rider\RiderRating\RiderRatingController::class, 'rider_add_rating']);

        // Show my Trip
        Route::post('trips/{page?}', [TripController::class, 'trips']);
        Route::post('specific/trip', [App\Http\Controllers\Api\DriverRider\DriverRiderController::class, 'specific_trip']);
        
        // Show rider bonds
        Route::post('bond/{page?}', [App\Http\Controllers\Api\Rider\BoxRiderQueryController::class, 'get_bonds']);
        

        //Rider Payment
        Route::post('payment', [PaymentController::class, 'payment']);
        
        // Rider Messages
        Route::post('message', [RiderMessageController::class, 'RiderMessage']);
        
        //Rider support
        Route::post('/support/task/add', [App\Http\Controllers\Api\Rider\RiderSupport\RiderSupportController::class, 'add_task']);
        Route::post('/support/tasks/show', [App\Http\Controllers\Api\Rider\RiderSupport\RiderSupportController::class, 'show_task']);
        Route::post('/support/task/send/replay', [App\Http\Controllers\Api\Rider\RiderSupport\RiderSupportController::class, 'send_replay_task']);
        

    });
    
    
    
});

Route::get('/', function () {
    return 'test api';
});