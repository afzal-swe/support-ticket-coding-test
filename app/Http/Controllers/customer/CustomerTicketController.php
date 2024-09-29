<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;


class CustomerTicketController extends Controller
{
    //

    private $db_tickets;

    public function __construct()
    {
        $this->db_tickets = "tickets";
    }


    public function Open_Ticket()
    {
        $ticket = DB::table('tickets')->where('user_id', Auth::id())->orderBy('id', 'DESC')->take(10)->get();
        return view('customer.ticket.view_ticket', compact('ticket'));
    }

    public function new_ticket()
    {
        return view('customer.ticket.new_ticket');
    }


    public function store_ticket(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required',
        ]);

        $data = array();
        $data['subject'] = $request->subject;
        $data['service'] = $request->service;
        $data['priority'] = $request->priority;
        $data['message'] = $request->message;
        $data['user_id'] = Auth::id();
        $data['status'] = 0;
        $data['date'] = date('Y-m-d');

        $image = $request->image;

        if ($image) {
            //working with image

            $photoname = uniqid() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(600, 350)->save('customer/images/ticket/' . $photoname);  //image intervention
            $data['image'] = 'customer/images/ticket/' . $photoname;   // public/files/brand/plus-point.jpg
        }

        DB::table('tickets')->insert($data);
        $notification = Session()->flash('message', 'Submit Issues Successfully!');
        return redirect()->route('open.ticket')->with($notification);
    }




    public function show_Ticket(Request $request)
    {

        $ticket = DB::table('tickets')->where('id', $request->id)->first();
        return view('customer.ticket.show_ticket', compact('ticket'));
    }

    public function Customer_Ticket_Delete($id)
    {
        DB::table($this->db_tickets)->where('id', $id)->delete();

        $notification = Session()->flash('message', 'Data Delete Successfully!');
        return redirect()->back()->with($notification);
    }
}
