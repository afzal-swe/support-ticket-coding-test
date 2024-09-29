<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{


    /**
     * Display the customer dashboard view.
     * 
     * @return \Illuminate\View\View The customer dashboard layout view.
     */
    public function Customer_Dashboard()
    {
        return view('customer.layouts.main');
    }
}
