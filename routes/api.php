<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('Api')->group(function () {
    Route::post('auth', 'AuthController@store');
    Route::post('user', 'UserController@store');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('plans', 'PlanController@index');
        Route::post('plans', 'PlanController@store');

        Route::get('offices', 'OfficeController@index');
        Route::post('offices', 'OfficeController@store');

        Route::get('customers', 'CustomerController@index');
        Route::post('customers', 'CustomerController@store');

        Route::get('employees/{customer_id?}', 'EmployeeController@index');
        Route::post('employees', 'EmployeeController@store');

        Route::post('upload', 'FileController@store');
      });
});
