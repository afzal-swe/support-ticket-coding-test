<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TicketController extends Controller
{
    //
    private $db_tickets;

    public function __construct()
    {
        $this->db_tickets = "tickets";
    }


    public function View_All_Ticket()
    {

        $view_ticket = DB::table($this->db_tickets)->orderBy('id', 'DESC')->get();
        dd($view_ticket);
    }
}
