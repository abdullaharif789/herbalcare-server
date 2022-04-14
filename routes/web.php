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

Route::post('/login', 'App\Http\Controllers\ApiAuthController@login')->name('login.api');
Route::apiResource('products', 'App\Http\Controllers\ProductController');
Route::apiResource('variants', 'App\Http\Controllers\VariantController');
