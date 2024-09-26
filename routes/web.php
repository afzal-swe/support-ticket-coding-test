<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\indexController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/'], function () {
    Route::controller(indexController::class)->group(function () {
        Route::get('/', 'home_page')->name('home_page');
        Route::get('/customer-logout', 'customer_logout')->name('customer.logout');
    });
    // return view('welcome')->name('home');
});

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'customer'], function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/dashboard', 'Customer_Dashboard')->name('Customer_Dashboard');
        });
    });
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
