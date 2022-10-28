<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;

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

Route::group([
    'namespace' => 'App\Http\Controllers\Api'
    ], function(){
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('login', 'AuthController@login');

        Route::group([
            'middleware' => 'auth:api',
            ], function(){
                Route::post('logout', 'AuthController@logout');
        
        });
});

// Route::group([
//     'middleware' => 'auth:api',
//     'namespace' => 'App\Http\Controllers\Api'
//     ], function(){
//         Route::post('logout', 'AuthController@logout');

// });




Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers\Api'
    ], function(){
    Route::get('product','ProductController@index');
    Route::get('product/{id}','ProductController@show');
    Route::post('product','ProductController@store');
    Route::put('product/{id}','ProductController@update');
    Route::delete('product/{id}', 'ProductController@destroy');

});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers\Api'
    ], function(){
    Route::get('customer','CustomerController@index');
    Route::get('customer/{id}','CustomerController@show');
    Route::post('customer','CustomerController@store');
    Route::put('customer/{id}','CustomerController@update');
    Route::delete('customer/{id}', 'CustomerController@destroy');

});

Route::apiResource('customers', CustomerController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
