<?php

namespace App\Http\Controllers;

use App\guest;
use App\reservation;
use App\room;
use App\room_type;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class roomController extends Controller
{
	public function __construct()
    {
        $this->middleware('web');
    }

    public function getRooms(Request $request)
    {
    	$this->validate($request, [
            'in_date' => 'required|date|after:yesterday',
            'out_date' => 'required|date|after:in_date'
        ]);
    	
    	$dates = array($request->in_date, $request->out_date);
    	return view('rooms', compact('dates'));
    }

	public function book(Request $request){
		
		$this->validate($request, [
            'id' => 'required',
            'email' => 'required|email|max:255',
            'name' => 'required',
            'room_id' => 'required|exists:rooms,id',
            'in_date' => 'required|date|after:yesterday',
            'out_date' => 'required|date|after:in_date',
            'floor' => 'required|exists:rooms,floor'
        ]);

		$in_date = DateTime::createFromFormat("Y-m-d", $request->in_date);
 		$out_date = DateTime::createFromFormat("Y-m-d", $request->out_date);
 		
 		$guest = guest::where('id',$request->id)->first();
 		if($guest == null){
 			$guest = new guest();
 			$guest->id = $request->id;
 			$guest->name = $request->name;
 			$guest->email = $request->email;
 			$guest->save();
 		}
        $room = room::where('id', $request->room_id)->where('floor',$request->floor)->first();
        $reservation = new reservation();
		$reservation->room_id = $request->room_id;
		$reservation->guest_id = $request->id;
		$reservation->in_day = $in_date->format("d");
		$reservation->in_month = $in_date->format("m");
		$reservation->in_year = $in_date->format("Y");
		$reservation->out_day = $out_date->format("d");
		$reservation->out_month = $out_date->format("m");
		$reservation->out_year = $out_date->format("Y");
        $reservation->floor = $request->floor;
        $reservation->room_type_id = $room->type_id;
		$reservation->save();


        $eventData = ['event' => 'BookingRoom', 'data' => 'Updates'];
        Redis::publish('admin-channel', json_encode($eventData));

        return redirect('/')->with('success', 'Room Booked successfully');
	} 

	public function bookView(Request $request){
        $this->validate($request, [
            'id' => 'required|exists:rooms,id',
            'in_date' => 'required|date|after:yesterday',
            'out_date' => 'required|date|after:in_date',
            'floor' => 'required|exists:rooms,floor'
        ]);
        $dates = array($request->id,$request->in_date, $request->out_date, $request->floor);
        return view('bookView', compact('dates'));
    }

    public function getRoomsByType(Request $request){
    	$this->validate($request, [
            'in_date' => 'required|date|after:yesterday',
            'out_date' => 'required|date|after:in_date',
            'type_name' => 'required'
        ]);
    	$type = room_type::where('name',$request->type_name)->first();
    	$avail_rooms = room::where('type_id',$type->id)->where('avail',1)->withCount('reservations')->get();
    	$check_in = new DateTime();
    	$check_out = new DateTime();
    	$rooms = array();
    	foreach ($avail_rooms as $avail) {
    		if($avail->reservations_count == 0){
    			array_push($rooms, $avail);	
    		}else{
    			$reservations = reservation::where('room_id', $avail->id)->get();
    			foreach ($reservations as $res) {
		    		$check_in->setDate($res->in_year, $res->in_month, $res->in_day);
		    		$check_out->setDate($res->out_year, $res->out_month, $res->out_day);
		    		if($check_in->format("Y-m-d") > $request->in_date){
						if($check_in->format("Y-m-d") < $request->out_date){
		    				if(($key = array_search($avail, $rooms)) == false) {
					    		array_push($rooms, $res->room);	
							}
		    			}

		    		}
		    		else if ($check_out->format("Y-m-d") < $request->in_date) {
		    			if(($key = array_search($avail, $rooms)) == false) {
				    		array_push($rooms, $res->room);	
						}
		    		}
		    		else if(($key = array_search($avail, $rooms)) !== false) {
					    unset($rooms[$key]);
					    break;
					}
		    	}
    		}
    	}
    	$dates = array($request->in_date, $request->out_date);
    	return view('rooms', compact('rooms'), compact('dates'));
    } 
}


/*

in 2010     >  2016 no
out 2011    < 2016   !exist? push

in 2012     > 2016  no
out 2013	<   2016  !exist?  no

in 2014     > 2016 no
out 2015	< 2016     !exist? no

in 2016     > 2016  no
out 2017    < 2016  no  
         (exist)  del


*/
