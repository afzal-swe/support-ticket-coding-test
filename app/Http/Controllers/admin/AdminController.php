<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{







    /**
     * Display the appropriate dashboard view based on the authenticated user's role.
     * 
     * @return \Illuminate\View\View The view for either the admin or customer dashboard layout.
     */
    public function Admin_dashboard()
    {
        // Check if the authenticated user has an admin role (role == 1).
        if (Auth()->user()->role == 1) {
            return view('admin.layouts.main'); // Show the admin dashboard layout.
        } else {
            return view('customer.layouts.main'); // Show the customer dashboard layout.
        }
    }








    /**
     * Log the admin user out and redirect to the home page.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the home page after logging out.
     */
    public function Admin_logout()
    {
        // Log the current user out of the application.
        Auth::logout();

        // Redirect the user to the home page.
        return redirect()->route('home_page');
    }
}
