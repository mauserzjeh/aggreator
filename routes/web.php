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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',        [\App\Http\Controllers\Authentication\LoginController::class,       'index'])   ->name('login');
Route::post('/login',       [\App\Http\Controllers\Authentication\LoginController::class,       'login'])   ->name('login.submit');
Route::get('/register',     [\App\Http\Controllers\Authentication\RegisterController::class,    'index'])   ->name('register');
Route::post('/register',    [\App\Http\Controllers\Authentication\RegisterController::class,    'register'])->name('register.submit');

/* SERVICE PROVIDERS */
Route::group(['prefix' => 'service-providers', 'middleware' => 'auth'], function() {
    Route::get('/courier/home', [\App\Http\Controllers\Frontend\Courier\HomeController::class, 'index'])->name('courier.home');
    Route::get('/manager/home', [\App\Http\Controllers\Frontend\Manager\HomeController::class, 'index'])->name('manager.home');
});

/* CUSTOMERS */
Route::group(['prefix' => 'customers', 'middleware' => 'auth'], function() {
    Route::get('/home', [\App\Http\Controllers\Frontend\Customer\HomeController::class, 'index'])->name('customer.home');
});
