<?php

namespace App\Http\Controllers;

use App\del_reservation;
use App\reservation;
use App\room;
use App\room_type;
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
        return view('admin.main');
    }

    public function RoomView()
    {
        $types = room_type::get();
        return view('rooms_settings', compact('types'));
    }
    
    public function addRoom(Request $request)
    {
        $this->validate($request, [
            'no' => 'required|integer',
            'type_name' => 'required',
            'active' => 'required|integer',
            'floor' => 'required|integer',
        ]);
        if($request->active > $request->no){
            $fail = "error Check active rooms number!!";
            return redirect('/rooms/settings')->with('fail', $fail);
        }
        $room = room::where('floor',$request->floor)->orderBy('id', 'desc')->first();
        $from = isset($room) ? $room->id + 1 : 1;
        $type = room_type::where('name',$request->type_name)->first();
        for ($i=0; $i < $request->no; $i++) { 
            $room = new room();
            $room->id = $from;
            $room->floor = $request->floor;
            $room->type_id = $type->id;
            if($i < $request->active){
                $room->avail = 1;
            }else{
                $room->avail = 0;
            }
            $room->save();
            $from++;   
        }
        
        $success = "The rooms has been added successfully!";
        return redirect('/rooms/settings')->with('success', $success);
    }

    public function updateRoom(Request $request)
    {
        $this->validate($request, [
            'type_name' => 'required',
            'floor' => 'required|exists:rooms,floor',
            'id' => 'required|exists:rooms,id',
            'status' => 'required|in:0,1',
        ]);
        $type = room_type::where('name',$request->type_name)->first();
        $room = room::where('id',$request->id)
                    ->where('floor',$request->floor)
                    ->where('type_id',$type->id)
                    ->first();
        $room->avail = $request->status;
        $room->save();
        $success = "The rooms has been updated successfully!";
        return redirect('/rooms/settings')->with('success', $success);
    }
    
    public function availRoomsView(){
        // $rooms = room::where('avail',1)->orderBy('id', 'asc')->get();
        // return view('rooms', compact('rooms'));
    }

    public function busyRoomsView(){
        // $rooms = room::where('avail',0)->orderBy('id', 'asc')->get();
        // return view('rooms', compact('rooms'));
    }

    public function resUpdateView(){
        return view('resUpdate');
    }

    public function updateRes(Request $request){
        $this->validate($request, [
            'room_id' => 'required|exists:rooms,id',
            'floor' => 'required|exists:rooms,floor',
            'guest_id' => 'required|exists:guests,id',
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
        $del_reservation->floor = $reservation->floor;
        $del_reservation->guest_id = $request->guest_id;
        $del_reservation->room_id = $request->room_id;
        $del_reservation->save();
        
        if($del_reservation != null){
            $reservation->forceDelete();
            $success = "reservation has been canceled";
            return view('resUpdate', compact('success'));
        }    
        
    }

    public function TypeView(){
        $types = room_type::get();
        return view('RoomType', compact('types'));
    } 
     
    public function addType(Request $request){
        
        $this->validate($request, [
            'name' => 'required|unique:room_types',
            'max' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        $type = new room_type();
        $type->name = $request->name;
        $type->max_occupancy = $request->max;
        $type->base_price = $request->price;
        $type->description = $request->description;
        $type->save();

        $status = "Sucessfully Added";
        return redirect('/types/settings')->with('status', $status);
    }
 
    public function updateType(Request $request){
        
        $this->validate($request, [
            'type_name' => 'required',
        ]);

        $type = room_type::where('name',$request->type_name)->first();
        $type->max_occupancy = $request->max != null ? $request->max : $type->max_occupancy;
        $type->base_price = $request->price != null ? $request->price : $type->base_price;
        $type->description = $request->description != null ? $request->description : $type->description;
        $type->save();

        $status = " Sucessfully Updated";
        return redirect('/types/settings')->with('status', $status);
    } 
}
