<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\TicketController;


Route::middleware(['is_admin'])->group(function () {
    Route::group(['prefix' => 'dashboard'], function () {
        // Admin Home Route Section Start //
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', 'Admin_dashboard')->name('admin_dashboard');
            Route::get('/logout', 'Admin_logout')->name('admin.logout');
        });


        Route::group(['prefix' => 'ticket'], function () {
            // Admin Home Route Section Start //
            Route::controller(TicketController::class)->group(function () {
                Route::get('/', 'View_All_Ticket')->name('view_all_ticket');
                Route::get('/delete/{id}', 'Ticket_Delete')->name('ticket.delete');
            });
        });
    });
});

require __DIR__ . '/auth.php';
