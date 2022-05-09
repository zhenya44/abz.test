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


Route::get('users', 'UserController@index');
Route::get('users/{id}', 'UserController@show')->middleware('request.add.id');
Route::post('users', 'UserController@store')->middleware('check.token');
Route::get('token', 'TokenController@index');
Route::get('positions', 'PositionController@index');
