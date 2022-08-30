<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
    return redirect('/home');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(\App\Http\Controllers\Customer\HomeController::class)->prefix('customer')->group(function () {
    Route::get('/home', 'index')->name('customer.home');
    Route::post('/addToCart', 'addToCart')->name('customer.addToCart');
});

Route::controller(\App\Http\Controllers\Customer\CartsController::class)->prefix('customer')->group(function () {
    Route::get('/carts', 'index')->name('customer.carts');
    Route::get('/carts/{id}', 'show')->name('customer.detailCart');
    Route::post('/carts/update/{id}', 'update')->name('customer.updateCart');
    Route::post('/carts/delete/{id}', 'destroy')->name('customer.deleteCart');
});
Route::get('cashier/home', function () {
})->name('cashier.home');


Route::get('manager/home', function () {
})->name('manager.home');


// Route::controller(CustomerController::class)->prefix('customer')->group(function () {

//     Route::get('/', 'index');
//     Route::get('/{id}', 'show');
//     Route::get('/create', 'create');

//     Route::get('/edit/{id}', 'edit');
//     Route::get('delete', 'edit');
// });

// Route::get('/customer/home', function () {
// })->name('customer.home');
// Route::get('/customer/carts', function () {
//     return "Halo";
// })->middleware('role:Customer');
// Route::get('/customer/histories', function () {
// });
// Route::get('/customer/profile', function () {
// });

// Route::get('/cashier/home', function () {

//     return "Ini homenya cashier";
// });


// Route::get('/cashier/profile', function () {
// });
