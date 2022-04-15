<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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
Route::controller(CustomerController::class)->group(function(){
    Route::get('customers', 'index');
    Route::get('customers.data_list', 'data_list')->name('customers.data_list');
    Route::get('customers.data_chart', 'data_chart')->name('customers.data_chart');
    Route::post('customers', 'store')->name('customers.store');
});
