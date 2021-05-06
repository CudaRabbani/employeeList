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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//ToDo: Add custom auth middleware in future for user authenticaiton
Route::prefix('employee')->group(function () {
    Route::get('/', 'EmployeeController@index');
    Route::get('/{employee}', 'EmployeeController@get');
    Route::post('/', 'EmployeeController@store');
    Route::put('/{employee}', 'EmployeeController@update');
    Route::delete('/{employee}', 'EmployeeController@destroy');
});

