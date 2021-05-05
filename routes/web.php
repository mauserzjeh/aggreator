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
    
    ///////////////////////// GENERAL ROUTES /////////////////////////
    Route::get('/home',         [\App\Http\Controllers\Frontend\HomeController::class,              'index'])   ->name('home');
    Route::get('/profile',      [\App\Http\Controllers\Frontend\ProfileController::class,           'index'])   ->name('profile');
    Route::post('/profile',     [\App\Http\Controllers\Frontend\ProfileController::class,           'update'])  ->name('profile.update');

    
    
    
    ///////////////////////// MANAGER ROUTES /////////////////////////

    //Restaurant
    Route::get('/restaurant-details',           [\App\Http\Controllers\Frontend\RestaurantController::class,    'index'])           ->name('restaurant.details');
    Route::post('/restaurant-details',          [\App\Http\Controllers\Frontend\RestaurantController::class,    'update'])          ->name('restaurant.update');
    Route::post('/restaurant-details/schedule', [\App\Http\Controllers\Frontend\RestaurantController::class,    'update_schedule']) ->name('restaurant.update.schedule');
    
    //Menu
    Route::get('/menu',                                 [\App\Http\Controllers\Frontend\MenuController::class,          'index'])           ->name('menu');
    Route::get('/menu/{itemId}/edit',                   [\App\Http\Controllers\Frontend\MenuController::class,          'edit'])            ->name('menu.edit');
    Route::post('/menu/{itemId}/save',                  [\App\Http\Controllers\Frontend\MenuController::class,          'save'])            ->name('menu.save');
    Route::get('/menu/{itemId}/delete',                 [\App\Http\Controllers\Frontend\MenuController::class,          'delete'])          ->name('menu.delete');
    
    //Menu categories
    Route::get('/menu-categories',                      [\App\Http\Controllers\Frontend\MenuController::class,          'categories'])      ->name('menu.categories');
    Route::get('/menu-categories/{categoryId}/edit',    [\App\Http\Controllers\Frontend\MenuController::class,          'edit_category'])   ->name('menu.categories.edit');
    Route::post('/menu-categories/{categoryId}/save',   [\App\Http\Controllers\Frontend\MenuController::class,          'save_category'])   ->name('menu.categories.save');
    Route::get('/menu-categories/{categoryId}/delete',  [\App\Http\Controllers\Frontend\MenuController::class,          'delete_category']) ->name('menu.categories.delete');
    
    //Orders
    Route::get('/restaurant-orders',                    [\App\Http\Controllers\Frontend\OrderController::class, 'orders_index'])    ->name('restaurant.orders');
    Route::get('/restaurant-orders/{orderId}/info',     [\App\Http\Controllers\Frontend\OrderController::class, 'order_info'])      ->name('order.info');
    Route::post('/restaurant-orders/{orderId}/update',  [\App\Http\Controllers\Frontend\OrderController::class, 'order_update'])    ->name('order.update');
    
    //Discounts
    Route::get('/discounts',                        [\App\Http\Controllers\Frontend\DiscountController::class, 'index'])    ->name('discounts');
    Route::get('/discounts/{discountId}/edit',      [\App\Http\Controllers\Frontend\DiscountController::class, 'edit'])     ->name('discount.edit');
    Route::post('/discounts/{discountId}/save',     [\App\Http\Controllers\Frontend\DiscountController::class, 'save'])     ->name('discount.save');
    Route::get('/discounts/{discountId}/delete',    [\App\Http\Controllers\Frontend\DiscountController::class, 'delete'])   ->name('discount.delete');

    ///////////////////////// CUSTOMER ROUTES /////////////////////////

    //Delivery info
    Route::get('/delivery-info',    [\App\Http\Controllers\Frontend\CustomerController::class, 'delivery_info']) ->name('deliveryinfo');
    Route::post('/delivery-info',   [\App\Http\Controllers\Frontend\CustomerController::class, 'update_delivery_info'])->name('deliveryinfo.update');

    //Restaurant actions
    Route::get('/restaurants',                                  [\App\Http\Controllers\Frontend\RestaurantController::class, 'restaurants'])            ->name('restaurants');
    Route::get('/restaurants/{restaurantId}/info',              [\App\Http\Controllers\Frontend\RestaurantController::class, 'restaurant_info'])        ->name('restaurant.info');
    Route::post('/restaurants/{restaurantId}/checkout',         [\App\Http\Controllers\Frontend\RestaurantController::class, 'restaurant_checkout'])    ->name('restaurant.checkout');
    Route::post('/restaurants/{restaurantId}/finalize-order',   [\App\Http\Controllers\Frontend\RestaurantController::class, 'finalize_order'])         ->name('finalize.order');

    //Orders
    Route::get('/my-orders',            [\App\Http\Controllers\Frontend\OrderController::class, 'customer_orders'])     ->name('customer.orders');
    Route::get('/my-orders/{orderId}',  [\App\Http\Controllers\Frontend\OrderController::class, 'customer_order_info']) ->name('customer.order.info');
    
    
    ///////////////////////// COURIER ROUTES /////////////////////////

    //Availability
    Route::get('/availability',     [\App\Http\Controllers\Frontend\CourierController::class, 'availability_index'])    ->name('availability');
    Route::post('/availability',    [\App\Http\Controllers\Frontend\CourierController::class, 'update_availability'])   ->name('availability.update');

    Route::get('/my-deliveries',                        [\App\Http\Controllers\Frontend\OrderController::class, 'courier_orders'])          ->name('courier.orders');
    Route::get('/my-deliveries/{orderId}',              [\App\Http\Controllers\Frontend\OrderController::class, 'courier_order_info'])      ->name('courier.order.info');
    Route::get('/my-deliveries/{orderId}/delivered',    [\App\Http\Controllers\Frontend\OrderController::class, 'courier_order_delivered']) ->name('courier.order.delivered');
    Route::get('/my-deliveries/{orderId}/reject',       [\App\Http\Controllers\Frontend\OrderController::class, 'courier_order_reject'])    ->name('courier.order.reject');
});
