<?php

namespace App\Http\Controllers;

use App\del_reservation;
use App\reservation;
use App\room;
use DateTime;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function addRoomView()
    {
        return view('addRoom');
    }

    public function addRoom(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|unique:rooms|max:10',
            'name' => 'required',
            'max' => 'required',
            'description' => 'required',
            'price' => 'required',
            'status' => 'required|in:0,1',
        ]);

        $room = new room();
        $room->id = $request->id;
        $room->name = $request->name;
        $room->description = $request->description;
        $room->max = $request->max;
        $room->avail = $request->status;
        $room->base_price = $request->price;
        $room->save();

        return view('addRoom', compact('room'));
    }

    public function updateRoomView()
    {
        return view('updateRoom');
    }

    public function updateRoom(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|max:10',
            'status' => 'required|in:0,1',
        ]);

        $room = room::where('id',$request->id)->first();
        if($request->name != null){
            $room->name = $request->name;
        }
        if($request->description != null){
            $room->description = $request->description;
        }
        if($request->max != null){
            $room->max = $request->max;
        }
        if($request->price != null){
            $room->base_price = $request->price;
        }
        
        $room->avail = $request->status;
        $room->save();

        return view('addRoom', compact('room'));
    }
    
    public function availRoomsView(){
        $rooms = room::where('avail',1)->orderBy('id', 'asc')->get();
        return view('rooms', compact('rooms'));
    }

    public function busyRoomsView(){
        $rooms = room::where('avail',0)->orderBy('id', 'asc')->get();
        return view('rooms', compact('rooms'));
    }

    public function resUpdateView(){
        return view('resUpdate');
    }

    public function updateRes(Request $request){
        $this->validate($request, [
            'room_id' => 'required',
            'guest_id' => 'required',
            'in_date' => 'required|date',
        ]);

        $in_date = DateTime::createFromFormat("Y-m-d", $request->in_date);
        $reservation = reservation::where('room_id',$request->room_id)
                                  ->where('guest_id', $request->guest_id)
                                  ->where('in_day',$in_date->format("d") )
                                  ->where('in_month',$in_date->format("m") )
                                  ->where('in_year',$in_date->format("Y") )
                                  ->first();
        if($reservation == null){
            $faild = "reservation not found!";
            return view('resUpdate', compact('faild'));
        }
        $del_reservation = new del_reservation();
        $del_reservation->in_day = $in_date->format("d");
        $del_reservation->in_month = $in_date->format("m");
        $del_reservation->in_year = $in_date->format("Y");
        $del_reservation->out_day = $reservation->out_day;
        $del_reservation->out_month = $reservation->out_month;
        $del_reservation->out_year = $reservation->out_year;
        $del_reservation->guest_id = $request->guest_id;
        $del_reservation->room_id = $request->room_id;
        $del_reservation->save();
        
        if($del_reservation != null){
            $reservation->forceDelete();
            $success = "reservation has been canceled";
            return view('resUpdate', compact('success'));
        }    
        
    }

     
}
