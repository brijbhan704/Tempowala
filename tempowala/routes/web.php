<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logout', function () {
    Auth::logout();
    return view('login');
});

Route::post('/send_message', 'MessageController@send_message');
Route::get('/send_message', 'MessageController@send_message');



Route::group(['middleware' => 'App\Http\Middleware\AuthMiddleware'], function () {
    Route::get('/users', 'UserController@index');
    Route::post('/userIndexAjax', 'UserController@userIndexAjax');
        
    Route::get('/', 'HomeController@index')->name('home');  
    
    

    Route::get('/vehicles', 'VehicleController@index');  
    Route::post('/vehicles/deleteImage', 'VehicleController@deleteImage');
    Route::post('/vehicles/vehicleIndexAjax', 'VehicleController@vehicleIndexAjax');
    Route::post('/vehicles/add', 'VehicleController@add');
    Route::get('/vehicles/add', 'VehicleController@add');
    Route::get('/vehicles/edit/{id}', 'VehicleController@edit');
    Route::post('/vehicles/update/{id}', 'VehicleController@update');
    Route::get('/vehicles/destroy/{id}', 'VehicleController@destroy');
    Route::post('/vehicles/uploadFiles/{id}', 'VehicleController@uploadFiles');
    
    Route::get('/vehicletypes', 'VehicletypeController@index');  
    Route::post('/vehicletypes/vehicleTypeIndexAjax', 'VehicletypeController@vehicleTypeIndexAjax');
    Route::post('/vehicletypes/add', 'VehicletypeController@add');
    Route::get('/vehicletypes/add', 'VehicletypeController@add');
    Route::get('/vehicletypes/edit/{id}', 'VehicletypeController@edit');
    Route::post('/vehicletypes/update/{id}', 'VehicletypeController@update');
    Route::get('/vehicletypes/destroy/{id}', 'VehicletypeController@destroy');
    
    Route::get('/messages', 'MessageController@index');  
    Route::post('/messages/messageIndexAjax', 'MessageController@messageIndexAjax');
    Route::post('/messages/add', 'MessageController@add');
    Route::get('/messages/add', 'MessageController@add');
    Route::get('/messages/edit/{id}', 'MessageController@edit');
    Route::post('/messages/update/{id}', 'MessageController@update');
    Route::get('/messages/destroy/{id}', 'MessageController@destroy');
    Route::post('/messages/getMessageById', 'MessageController@getMessageById');
    
    Route::get('/coupons', 'CouponController@index');  
    Route::post('/coupons/couponIndexAjax', 'CouponController@couponIndexAjax');
    Route::post('/coupons/add', 'CouponController@add');
    Route::get('/coupons/add', 'CouponController@add');
    Route::get('/coupons/edit/{id}', 'CouponController@edit');
    Route::post('/coupons/update/{id}', 'CouponController@update');
    Route::get('/coupons/destroy/{id}', 'CouponController@destroy');
    
    Route::get('/bookings', 'BookingController@index');  
    Route::post('/bookings/bookingIndexAjax', 'BookingController@bookingIndexAjax');
    Route::post('/vehicletypes/add', 'VehicletypeController@add');
    Route::get('/vehicletypes/add', 'VehicletypeController@add');
    Route::get('/bookings/edit/{id}', 'BookingController@edit');
    Route::post('/bookings/update/{id}', 'BookingController@update');
    Route::post('/bookings/sendNotification', 'BookingController@sendNotification');
    Route::post('/bookings/getNotification', 'BookingController@getNotification');
    

    
    /* users routing */
    //Route::get('/users', 'UserController@index');
    Route::get('/users/edit/{id}', 'UserController@edit');
    Route::get('/users/changepass', 'UserController@changepass');
    Route::post('/users/change_password', 'UserController@change_password');
    Route::post('/users/update/{id}', 'UserController@update');
    Route::post('/users/create', 'UserController@create');
    Route::get('/users/destroy/{id}', 'UserController@destroy');

    Route::get('/users/settings/{id}', 'UserController@settings');
    Route::post('/users/settings/{id}', 'UserController@settings');


});

//Route::get('/', 'PagesController@index');

// Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function(){
//     Route::match(['get', 'post'], '/adminOnlyPage/', 'HomeController@admin');
// });

Auth::routes();

/* error routing */
Route::get('/error',function(){
   abort('custom');
});
