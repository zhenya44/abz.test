<?php

use Illuminate\Support\Facades\Route;

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


Route::get('users', function () {
    return view('users');
});

Route::get('users/create', function () {
    return view('users_create');
});

Route::get('/', function () {
    return view('welcome');
});
