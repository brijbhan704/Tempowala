<?php

use Illuminate\Http\Request;

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
Use App\Rest;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::post('userList', 'UserController@getUserList');
Route::post('getUserByCity', 'UserController@getUserByCity');
Route::post('sendotp', 'UserController@sendotp');
Route::post('otpVerification', 'UserController@otpVerification');
Route::post('resentRegisterOtp', 'UserController@resentRegisterOtp');
Route::post('forgotPassword', 'UserController@forgotPassword'); 
Route::post('verifyForgotPassword', 'UserController@verifyForgotPassword'); 
Route::post('addRating', 'RatingController@addRating');  
Route::get('commonData', 'UserController@commonData');  
Route::post('contactus', 'UserController@contactus');

Route::post('vechileList', 'VehicleController@vechileList');

Route::get('generate-pdf', 'BookingController@pdfview')->name('generate-pdf');

//Route::post('booking', 'BookingController@booking');
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');       
    Route::post('apilogout', 'UserController@apilogout');
    Route::post('addEvent', 'EventController@addEvent');
    Route::post('changePassword', 'UserController@changePassword');
    Route::post('getMyEventList', 'EventController@getMyEventList');      
    Route::post('editMyEvent', 'EventController@editMyEvent');
    Route::post('editMyProfile', 'UserController@editMyProfile');    
    Route::post('vechileBook', 'VehicleController@vechileBook');
    Route::post('booking', 'BookingController@booking');
    Route::post('myBooking', 'BookingController@myBooking');
    Route::post('getBookingById', 'BookingController@getBookingById');
    Route::post('updateDeviceToken', 'UserController@updateDeviceToken');
    Route::post('getNotificationById', 'BookingController@getNotificationById');
    Route::post('getNotificationCount', 'BookingController@getNotificationCount');
    Route::post('readNotification', 'BookingController@readNotification');
    Route::post('checkCoupon', 'CouponController@checkCoupon');
    
    
});

