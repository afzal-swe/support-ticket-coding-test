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
    private $db_replies;

    public function __construct()
    {
        $this->db_tickets = "tickets";
        $this->db_replies = "replies";
    }


    public function View_All_Ticket()
    {

        $view_ticket = DB::table($this->db_tickets)->orderBy('id', 'DESC')
            ->join('users', 'tickets.user_id', 'users.id')
            ->select('tickets.*', 'users.name')
            ->get();
        return view('admin.ticket.view_ticket', compact('view_ticket'));
    }



    public function admin_ticket_reply(Request $request)
    {

        $ticket = DB::table('tickets')
            ->leftJoin('users', 'tickets.user_id', 'users.id')
            ->select('tickets.*', 'users.name')
            ->where('tickets.id', $request->id)
            ->first();
        // dd($ticket);
        return view('admin.ticket.reply_ticket', compact('ticket'));
    }


    public function Admin_Store_Reply(Request $request)
    {

        $validate = $request->validate([
            'message' => ['required'],
        ]);

        $data = array();
        $data['message'] = $request->message;
        $data['ticket_id'] = $request->ticket_id;
        $data['user_id'] = 0;
        $data['reply_date'] = date('Y-m-d');

        DB::table($this->db_replies)->insert($data);
        DB::table('tickets')->where('id', $request->ticket_id)->update(['status' => 1]);

        $notification = Session()->flash('message', 'Reply Successfully!');
        return redirect()->back()->with($notification);
    }



    public function close_ticket(Request $request)
    {
        DB::table('tickets')->where('id', $request->id)->update(['status' => 2]);

        $notification = Session()->flash('message', 'Close Successfully!');
        return redirect()->back()->with($notification);
    }

    public function Ticket_Delete(Request $request, $id)
    {


        DB::table($this->db_tickets)->where('id', $id)->delete();

        $notification = Session()->flash('message', 'Data Delete Successfully!');
        return redirect()->back()->with($notification);
    }
}
