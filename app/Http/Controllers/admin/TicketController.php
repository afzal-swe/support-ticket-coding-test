<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class TicketController extends Controller
{
    //
    private $db_tickets;
    private $db_replies;



    /**
     * Class constructor to initialize database table names for tickets and replies.
     */
    public function __construct()
    {
        // Define the table for storing ticket data.
        $this->db_tickets = "tickets";

        // Define the table for storing reply data.
        $this->db_replies = "replies";
    }







    /**
     * Retrieve and display all tickets along with the associated user's name.
     * 
     * @return \Illuminate\View\View Returns the view displaying all tickets.
     */
    public function View_All_Ticket()
    {

        $view_ticket = DB::table($this->db_tickets)->orderBy('id', 'DESC')
            ->join('users', 'tickets.user_id', 'users.id')
            ->select('tickets.*', 'users.name')
            ->get();

        // Return the view with the list of tickets.
        return view('admin.ticket.view_ticket', compact('view_ticket'));
    }








    /**
     * Display the reply form for a specific ticket, including the ticket details and the associated user's name.
     * 
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the ticket ID.
     * 
     * @return \Illuminate\View\View Returns the view displaying the ticket reply form with the ticket details.
     */
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






    /**
     * Store the admin's reply to a ticket and update the ticket status.
     * 
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing reply details and ticket ID.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirect back with a success notification after storing the reply.
     */
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






    /**
     * Close a ticket by updating its status to '2' and optionally send a notification email.
     * 
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the ticket ID.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirect back with a success notification after closing the ticket.
     */
    public function close_ticket(Request $request)
    {

        $data = DB::table('tickets')
            ->where('id', $request->id)
            ->update(['status' => 2]);

        // Mail::to($request->c_email)->send(new NotificationMail($data));

        $notification = Session()->flash('message', 'Close Successfully!');
        return redirect()->back()->with($notification);
    }






    /**
     * Delete a ticket from the database based on the provided ID.
     * 
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @param int $id The ID of the ticket to be deleted.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirect back with a success notification after deletion.
     */
    public function Ticket_Delete(Request $request, $id)
    {


        DB::table($this->db_tickets)->where('id', $id)->delete();

        $notification = Session()->flash('message', 'Data Delete Successfully!');
        return redirect()->back()->with($notification);
    }
}
