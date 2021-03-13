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


/**
 * Redirect already authenticated users from these routes
 */
Route::group(['middleware' => 'guest'], function() {
    Route::get('/', function () {
        return redirect('login');
    });
    
    Route::get('/login',        [\App\Http\Controllers\Authentication\LoginController::class,       'index'])   ->name('login');
    Route::post('/login',       [\App\Http\Controllers\Authentication\LoginController::class,       'login'])   ->name('login.submit');
    Route::get('/register',     [\App\Http\Controllers\Authentication\RegisterController::class,    'index'])   ->name('register');
    Route::post('/register',    [\App\Http\Controllers\Authentication\RegisterController::class,    'register'])->name('register.submit');

});

Route::post('/logout',      [\App\Http\Controllers\Authentication\LoginController::class,       'logout'])  ->name('logout');

/**
 * These routes can only be accessed while being authenticated
 */
Route::group(['middleware' => 'auth'], function() {
    Route::get('/home',         [\App\Http\Controllers\Frontend\HomeController::class,              'index'])   ->name('home');
    Route::get('/profile',      [\App\Http\Controllers\Frontend\ProfileController::class,           'index'])   ->name('profile');
    Route::post('/profile',     [\App\Http\Controllers\Frontend\ProfileController::class,           'update'])  ->name('profile.update');

    // Manager routes
    Route::get('/restaurant-details',   [\App\Http\Controllers\Frontend\RestaurantController::class,    'index'])       ->name('restaurant.details');
    Route::get('/menu',                 [\App\Http\Controllers\Frontend\MenuController::class,          'index'])       ->name('menu');
    Route::get('/menu-categories',      [\App\Http\Controllers\Frontend\MenuController::class,          'categories'])  ->name('menu.categories');
    Route::get('/orders',               [\App\Http\Controllers\Frontend\OrderController::class,         'index'])       ->name('orders');
});
