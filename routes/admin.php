<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;



// Route::get('/test', function () {
//     return view('admin.layouts.main');
// });


Route::group(['prefix' => 'author'], function () {
    // Admin Home Route Section Start //
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'Admin_dashboard')->name('admin_dashboard');
    });
});

require __DIR__ . '/auth.php';
