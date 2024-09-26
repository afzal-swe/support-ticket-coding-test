<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Middleware\AdminMiddleware;


Route::middleware(['is_admin'])->group(function () {
    Route::group(['prefix' => 'dashboard'], function () {
        // Admin Home Route Section Start //
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', 'Admin_dashboard')->name('admin_dashboard');
            Route::get('/logout', 'Admin_logout')->name('admin.logout');
        });
    });
});

require __DIR__ . '/auth.php';
