<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


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

        $view_ticket = DB::table($this->db_tickets)->orderBy('id', 'DESC')
            ->join('users', 'tickets.user_id', 'users.id')
            ->select('tickets.*', 'users.name')
            ->get();
        return view('admin.ticket.view_ticket', compact('view_ticket'));
    }

    public function Ticket_Delete(Request $request, $id)
    {


        DB::table($this->db_tickets)->where('id', $id)->delete();

        $notification = Session()->flash('message', 'Data Delete Successfully!');
        return redirect()->back()->with($notification);
    }
}
